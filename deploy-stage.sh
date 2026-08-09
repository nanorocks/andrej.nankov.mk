#!/usr/bin/env bash

set -Eeuo pipefail
umask 077

readonly EXPECTED_BRANCH='stage'
readonly DEFAULT_CPANEL_HOST='lu-shared04.cpanelplatform.com'
readonly DEFAULT_CPANEL_USER='nankovmk'
readonly DEFAULT_STAGE_DOMAIN='stage.nankov.mk'
readonly DEFAULT_REMOTE_APP_REL='public_html/cicd_projects/stage.nankov.mk'

readonly SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"

CPANEL_HOST="${CPANEL_HOST:-$DEFAULT_CPANEL_HOST}"
CPANEL_USER="${CPANEL_USER:-$DEFAULT_CPANEL_USER}"
STAGE_DOMAIN="${STAGE_DOMAIN:-$DEFAULT_STAGE_DOMAIN}"
REMOTE_APP_REL="${STAGE_REMOTE_APP_REL:-$DEFAULT_REMOTE_APP_REL}"
CPANEL_API_TOKEN="${CPANEL_API_TOKEN:-}"
ENV_FILE=''
BOOTSTRAP_ENV=false
PROVISION=false

TEMP_DIR=''
CURL_CONFIG=''
REMOTE_ARCHIVE_PENDING=false
REMOTE_GATEWAY_PENDING=false
ARCHIVE_NAME=''
GATEWAY_NAME=''

usage() {
    cat <<'EOF'
Usage: ./deploy-stage.sh [--provision] [--env-file PATH]
       ./deploy-stage.sh [--provision] --bootstrap-env PATH

Builds and tests the checked-out `stage` branch locally, uploads a production
artifact with cPanel UAPI, extracts it into stage.nankov.mk, runs Laravel
migrations/seeding/cache commands through a one-time protected finalizer, and
verifies the public health endpoints.

Required environment:
  CPANEL_API_TOKEN       Temporary cPanel API token (prompted when omitted)

Optional environment:
  CPANEL_HOST            Defaults to lu-shared04.cpanelplatform.com
  CPANEL_USER            Defaults to nankovmk
  STAGE_DOMAIN           Defaults to stage.nankov.mk
  STAGE_REMOTE_APP_REL   Defaults to public_html/cicd_projects/stage.nankov.mk

Options:
  --provision            Create stage.nankov.mk in cPanel when it is absent
  --env-file PATH        Upload PATH as the stage .env (mode 0600)
  --bootstrap-env PATH   Create an isolated cPanel database and a new stage
                         environment at PATH, then upload it (one-time only)
  -h, --help             Show this help
EOF
}

step() { printf '\n==> %s\n' "$1"; }
ok() { printf '    OK: %s\n' "$1"; }
fail() { printf 'ERROR: %s\n' "$1" >&2; exit 1; }

cleanup() {
    set +e

    if [[ "$REMOTE_GATEWAY_PENDING" == true && -n "$GATEWAY_NAME" && -f "$CURL_CONFIG" ]]; then
        if remote_file_exists "${REMOTE_PUBLIC}/${GATEWAY_NAME}"; then
            api2_fileop 'trash' "${REMOTE_APP_REL}/public/${GATEWAY_NAME}" >/dev/null 2>&1
        fi
    fi

    if [[ "$REMOTE_ARCHIVE_PENDING" == true && -n "$ARCHIVE_NAME" && -f "$CURL_CONFIG" ]]; then
        if remote_file_exists "${REMOTE_APP}/${ARCHIVE_NAME}"; then
            api2_fileop 'trash' "${REMOTE_APP_REL}/${ARCHIVE_NAME}" >/dev/null 2>&1
        fi
    fi

    if [[ -n "$TEMP_DIR" && -d "$TEMP_DIR" ]]; then
        rm -rf -- "$TEMP_DIR"
    fi
}
trap cleanup EXIT

while (($#)); do
    case "$1" in
        --provision)
            PROVISION=true
            shift
            ;;
        --env-file)
            (($# >= 2)) || fail '--env-file requires a path.'
            ENV_FILE="$2"
            shift 2
            ;;
        --bootstrap-env)
            (($# >= 2)) || fail '--bootstrap-env requires a path.'
            ENV_FILE="$2"
            BOOTSTRAP_ENV=true
            shift 2
            ;;
        -h|--help)
            usage
            exit 0
            ;;
        *)
            fail "Unknown argument: $1"
            ;;
    esac
done

for command_name in git php composer npm curl zip sed realpath tar find du cut mktemp; do
    command -v "$command_name" >/dev/null 2>&1 \
        || fail "$command_name is required."
done

if [[ -n "$ENV_FILE" ]]; then
    if [[ "$BOOTSTRAP_ENV" == true ]]; then
        ENV_FILE="$(realpath -m -- "$ENV_FILE")"
        [[ ! -e "$ENV_FILE" ]] \
            || fail "Refusing to overwrite existing environment file: $ENV_FILE"
        [[ -d "$(dirname -- "$ENV_FILE")" ]] \
            || fail "Environment file parent directory does not exist: $(dirname -- "$ENV_FILE")"
    else
        ENV_FILE="$(realpath -- "$ENV_FILE")"
        [[ -f "$ENV_FILE" ]] || fail "Environment file not found: $ENV_FILE"
    fi
fi

if [[ -z "$CPANEL_API_TOKEN" ]]; then
    read -r -s -p 'Temporary cPanel API token: ' CPANEL_API_TOKEN
    printf '\n'
fi
[[ -n "$CPANEL_API_TOKEN" ]] || fail 'CPANEL_API_TOKEN is required.'

TEMP_DIR="$(mktemp -d)"
CURL_CONFIG="$TEMP_DIR/cpanel-curl.conf"
{
    printf 'silent\n'
    printf 'show-error\n'
    printf 'fail-with-body\n'
    printf 'connect-timeout = 15\n'
    printf 'max-time = 600\n'
    printf 'header = "Authorization: cpanel %s:%s"\n' "$CPANEL_USER" "$CPANEL_API_TOKEN"
} > "$CURL_CONFIG"

readonly CPANEL_BASE_URL="https://${CPANEL_HOST}:2083"
readonly REMOTE_APP="/home/${CPANEL_USER}/${REMOTE_APP_REL}"
readonly REMOTE_PUBLIC="${REMOTE_APP}/public"
readonly EXPECTED_DOCUMENT_ROOT="$REMOTE_PUBLIC"

assert_uapi_success() {
    php -r '
        $payload = json_decode(stream_get_contents(STDIN), true);
        if (! is_array($payload) || ($payload["status"] ?? 0) !== 1) {
            fwrite(STDERR, "cPanel UAPI call failed:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n");
            exit(1);
        }
    '
}

assert_api2_success() {
    php -r '
        $payload = json_decode(stream_get_contents(STDIN), true);
        $result = $payload["cpanelresult"] ?? null;
        $eventOkay = ($result["event"]["result"] ?? 0) === 1;
        $itemsOkay = true;
        foreach (($result["data"] ?? []) as $item) {
            $itemsOkay = $itemsOkay && (($item["result"] ?? 0) === 1);
        }
        if (! is_array($result) || ! $eventOkay || ! $itemsOkay) {
            fwrite(STDERR, "cPanel API 2 call failed:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n");
            exit(1);
        }
    '
}

uapi_get() {
    local endpoint="$1"
    shift
    curl --config "$CURL_CONFIG" --get "${CPANEL_BASE_URL}/execute/${endpoint}" "$@"
}

api2_fileop() {
    local operation="$1"
    local source_files="$2"
    local destination_files="${3:-}"
    local metadata="${4:-}"
    local args=(
        --data-urlencode "cpanel_jsonapi_user=${CPANEL_USER}"
        --data-urlencode 'cpanel_jsonapi_apiversion=2'
        --data-urlencode 'cpanel_jsonapi_module=Fileman'
        --data-urlencode 'cpanel_jsonapi_func=fileop'
        --data-urlencode "op=${operation}"
        --data-urlencode "sourcefiles=${source_files}"
        --data-urlencode 'doubledecode=1'
    )

    [[ -z "$destination_files" ]] || args+=(--data-urlencode "destfiles=${destination_files}")
    [[ -z "$metadata" ]] || args+=(--data-urlencode "metadata=${metadata}")

    curl --config "$CURL_CONFIG" --get "${CPANEL_BASE_URL}/json-api/cpanel" "${args[@]}"
}

upload_file() {
    local local_file="$1"
    local remote_directory="$2"
    local remote_name="$3"

    curl --config "$CURL_CONFIG" \
        -F "file-1=@${local_file};filename=${remote_name}" \
        -F "dir=${remote_directory}" \
        "${CPANEL_BASE_URL}/execute/Fileman/upload_files"
}

save_file_content() {
    local local_file="$1"
    local remote_directory="$2"
    local remote_name="$3"

    # Use a POST body so environment contents never appear in a URL or API
    # access log. Unlike upload_files, save_file_content replaces an existing
    # file, which is required when rotating the stage environment.
    curl --config "$CURL_CONFIG" \
        --data-urlencode "dir=${remote_directory}" \
        --data-urlencode "file=${remote_name}" \
        --data-urlencode "content@${local_file}" \
        --data-urlencode 'from_charset=UTF-8' \
        --data-urlencode 'to_charset=UTF-8' \
        --data-urlencode 'fallback=0' \
        "${CPANEL_BASE_URL}/execute/Fileman/save_file_content"
}

remote_file_exists() {
    local path="$1"
    uapi_get 'Fileman/get_file_information' \
        --data-urlencode "path=${path}" \
        --data-urlencode 'show_hidden=1' \
        | php -r '
            $payload = json_decode(stream_get_contents(STDIN), true);
            exit((($payload["status"] ?? 0) === 1 && ($payload["data"]["exists"] ?? 0) === 1) ? 0 : 1);
        '
}

domain_document_root() {
    printf '%s' "$1" | php -r '
        $payload = json_decode(stream_get_contents(STDIN), true);
        $expected = $argv[1];
        foreach (($payload["data"] ?? []) as $domain) {
            if (($domain["domain"] ?? "") === $expected) {
                echo $domain["documentroot"] ?? "";
                exit(0);
            }
        }
    ' "$STAGE_DOMAIN"
}

validate_local_stage_env() {
    php "$SCRIPT_DIR/website/scripts/validate-stage-environment.php" \
        --file "$ENV_FILE" \
        --host "$STAGE_DOMAIN"
}

validate_remote_stage_env() {
    uapi_get 'Fileman/get_file_content' \
        --data-urlencode "dir=${REMOTE_APP}" \
        --data-urlencode 'file=.env' \
        --data-urlencode 'to_charset=UTF-8' \
        --data-urlencode 'update_html_document_encoding=0' \
        | php "$SCRIPT_DIR/website/scripts/validate-stage-environment.php" \
            --cpanel-json \
            --host "$STAGE_DOMAIN"
}

step 'Validating local stage branch'
[[ "$(git -C "$SCRIPT_DIR" branch --show-current)" == "$EXPECTED_BRANCH" ]] \
    || fail "Check out the $EXPECTED_BRANCH branch before deploying."
[[ -z "$(git -C "$SCRIPT_DIR" status --porcelain)" ]] \
    || fail 'The working tree must be clean.'

git -C "$SCRIPT_DIR" fetch --quiet origin "$EXPECTED_BRANCH"
readonly REVISION="$(git -C "$SCRIPT_DIR" rev-parse HEAD)"
readonly REMOTE_REVISION="$(git -C "$SCRIPT_DIR" rev-parse "origin/${EXPECTED_BRANCH}")"
[[ "$REVISION" == "$REMOTE_REVISION" ]] \
    || fail "Local $EXPECTED_BRANCH must exactly match origin/$EXPECTED_BRANCH."
ok "Deploying ${REVISION:0:12} from $EXPECTED_BRANCH"

step 'Checking cPanel authentication and stage domain'
domains_payload="$(uapi_get 'DomainInfo/domains_data' --data-urlencode 'format=list')"
printf '%s' "$domains_payload" | assert_uapi_success

domain_docroot="$(domain_document_root "$domains_payload")"

if [[ -z "$domain_docroot" ]]; then
    $PROVISION || fail "$STAGE_DOMAIN does not exist in cPanel. Re-run with --provision."

    [[ "$STAGE_DOMAIN" == "stage.nankov.mk" ]] \
        || fail '--provision is restricted to stage.nankov.mk.'

    provision_payload="$(uapi_get 'SubDomain/addsubdomain' \
        --data-urlencode 'domain=stage' \
        --data-urlencode 'rootdomain=nankov.mk' \
        --data-urlencode "dir=/${REMOTE_APP_REL}/public" \
        --data-urlencode 'disallowdot=1')"

    # Some cPanel builds create the virtual host before reporting that an
    # already-present DNS record prevented the last provisioning step.
    # Re-query the authoritative domain mapping before treating that as fatal.
    domains_payload="$(uapi_get 'DomainInfo/domains_data' --data-urlencode 'format=list')"
    printf '%s' "$domains_payload" | assert_uapi_success
    domain_docroot="$(domain_document_root "$domains_payload")"

    if [[ "$domain_docroot" != "$EXPECTED_DOCUMENT_ROOT" ]]; then
        printf '%s' "$provision_payload" | assert_uapi_success
        fail "$STAGE_DOMAIN was not created with the expected document root."
    fi
    ok "Created $STAGE_DOMAIN with document root $EXPECTED_DOCUMENT_ROOT"
else
    [[ "$domain_docroot" == "$EXPECTED_DOCUMENT_ROOT" ]] \
        || fail "$STAGE_DOMAIN points to $domain_docroot, expected $EXPECTED_DOCUMENT_ROOT."
    ok "$STAGE_DOMAIN document root is correct"
fi

if [[ "$BOOTSTRAP_ENV" == true ]]; then
    step 'Creating isolated stage database and environment'
    bootstrap_payload="$(uapi_get 'Mysql/setup_db_and_user' \
        --data-urlencode 'prefix=stg')"
    printf '%s' "$bootstrap_payload" | assert_uapi_success
    printf '%s' "$bootstrap_payload" \
        | php "$SCRIPT_DIR/website/scripts/create-stage-environment.php" \
            --output "$ENV_FILE" \
            --host "$STAGE_DOMAIN"
    ok "Created isolated stage environment at $ENV_FILE (mode 0600)"
fi

step 'Validating isolated stage environment'
if [[ -n "$ENV_FILE" ]]; then
    validate_local_stage_env
else
    remote_file_exists "${REMOTE_APP}/.env" \
        || fail "Missing ${REMOTE_APP}/.env. Re-run with --env-file PATH or --bootstrap-env PATH."
    validate_remote_stage_env
fi
ok 'Stage environment is isolated and safe for deployment'

step 'Preparing production artifact locally'
readonly BUILD_DIR="$TEMP_DIR/build"
mkdir -p "$BUILD_DIR"
git -C "$SCRIPT_DIR" archive "$REVISION:website" | tar -xf - -C "$BUILD_DIR"

(
    cd "$BUILD_DIR"
    composer install --no-interaction --prefer-dist
    npm ci --no-audit --no-fund
    npm run build
    php -d memory_limit=512M artisan test
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

    rm -rf -- node_modules tests .phpunit.cache
    rm -f -- database/database.sqlite public/hot
    find bootstrap/cache -mindepth 1 ! -name '.gitignore' -exec rm -rf -- {} +
    find storage -type f ! -name '.gitignore' -delete
    printf '%s\n' "$REVISION" > REVISION
)

ARCHIVE_NAME="stage-${REVISION}.zip"
readonly ARCHIVE_PATH="$TEMP_DIR/$ARCHIVE_NAME"
(
    cd "$BUILD_DIR"
    zip -q -r "$ARCHIVE_PATH" . \
        -x '.env' '.env.*' 'auth.json' 'node_modules/*' 'tests/*' \
        'storage/logs/*' 'storage/framework/cache/data/*' \
        'storage/framework/sessions/*' 'storage/framework/views/*' \
        'bootstrap/cache/*.php'
)
ok "Artifact ready: $(du -h "$ARCHIVE_PATH" | cut -f1)"

step 'Uploading and extracting artifact with cPanel API'
upload_payload="$(upload_file "$ARCHIVE_PATH" "$REMOTE_APP" "$ARCHIVE_NAME")"
printf '%s' "$upload_payload" | assert_uapi_success
REMOTE_ARCHIVE_PENDING=true

# For extract, cPanel resolves a relative destination beneath the archive's
# directory. Use the absolute application root to avoid a duplicated
# public_html/cicd_projects/... path inside the application.
extract_payload="$(api2_fileop 'extract' "${REMOTE_APP_REL}/${ARCHIVE_NAME}" "$REMOTE_APP")"
printf '%s' "$extract_payload" | assert_api2_success
ok 'Artifact extracted'

if [[ -n "$ENV_FILE" ]]; then
    step 'Uploading stage environment file'
    env_payload="$(save_file_content "$ENV_FILE" "$REMOTE_APP" '.env')"
    printf '%s' "$env_payload" | assert_uapi_success
    chmod_payload="$(api2_fileop 'chmod' "${REMOTE_APP_REL}/.env" '' '0600')"
    printf '%s' "$chmod_payload" | assert_api2_success
    ok 'Stage .env uploaded with mode 0600'
fi

step 'Installing one-time Laravel finalizer gateway'
readonly DEPLOY_TOKEN="$(php -r 'echo bin2hex(random_bytes(32));')"
GATEWAY_NAME="stage-deploy-${REVISION}.php"
readonly GATEWAY_PATH="$TEMP_DIR/$GATEWAY_NAME"

sed \
    -e "s/__DEPLOY_TOKEN__/${DEPLOY_TOKEN}/g" \
    -e "s/__EXPECTED_REVISION__/${REVISION}/g" \
    -e "s/__EXPECTED_HOST__/${STAGE_DOMAIN}/g" \
    "$BUILD_DIR/scripts/stage-deployment-gateway.php.tpl" > "$GATEWAY_PATH"

gateway_payload="$(upload_file "$GATEWAY_PATH" "$REMOTE_PUBLIC" "$GATEWAY_NAME")"
printf '%s' "$gateway_payload" | assert_uapi_success
REMOTE_GATEWAY_PENDING=true

step 'Running migrations, seeders, links, and Laravel caches'
finalizer_url="https://${STAGE_DOMAIN}/${GATEWAY_NAME}"
if ! finalizer_response="$(curl --silent --show-error --max-time 600 \
    --request POST \
    --header "X-Deploy-Token: ${DEPLOY_TOKEN}" \
    "$finalizer_url")"; then
    fail 'The one-time stage finalizer request failed. Check DNS and AutoSSL for stage.nankov.mk.'
fi

printf '%s' "$finalizer_response" | php -r '
    $payload = json_decode(stream_get_contents(STDIN), true);
    if (! is_array($payload) || ($payload["success"] ?? false) !== true) {
        fwrite(STDERR, "Stage finalizer failed:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n");
        exit(1);
    }
    foreach (($payload["steps"] ?? []) as $step) {
        fwrite(STDOUT, "    " . ($step["command"] ?? "unknown") . "\n");
    }
'
REMOTE_GATEWAY_PENDING=false

step 'Removing uploaded deployment archive'
trash_payload="$(api2_fileop 'trash' "${REMOTE_APP_REL}/${ARCHIVE_NAME}")"
printf '%s' "$trash_payload" | assert_api2_success
REMOTE_ARCHIVE_PENDING=false
ok 'Archive moved to cPanel Trash'

step 'Verifying stage deployment'
curl --fail --silent --show-error --max-time 30 "https://${STAGE_DOMAIN}/up" >/dev/null
curl --fail --silent --show-error --max-time 30 "https://${STAGE_DOMAIN}/" >/dev/null
ok "Stage deployment ${REVISION:0:12} is healthy at https://${STAGE_DOMAIN}/"
