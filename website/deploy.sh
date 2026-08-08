#!/usr/bin/env bash

# Guarded cPanel deployment for andrej.nankov.mk.
# Usage: bash deploy.sh production|staging [--yes] [--dry-run]

set -Eeuo pipefail

readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly RED='\033[0;31m'
readonly NC='\033[0m'

TARGET="${1:-}"
shift || true

ASSUME_YES=false
DRY_RUN=false

for argument in "$@"; do
    case "$argument" in
        --yes) ASSUME_YES=true ;;
        --dry-run) DRY_RUN=true ;;
        *) printf '%bUnknown option: %s%b\n' "$RED" "$argument" "$NC" >&2; exit 2 ;;
    esac
done

case "$TARGET" in
    production)
        readonly BRANCH='main'
        readonly REPOSITORY_ROOT='/home/nankovmk/public_html/cicd_projects/nankov.mk'
        readonly HEALTH_URL='https://andrej.nankov.mk/'
        ;;
    staging)
        readonly BRANCH='develop'
        readonly REPOSITORY_ROOT='/home/nankovmk/public_html/cicd_projects/stage.nankov.mk'
        readonly HEALTH_URL='https://stage.nankov.mk/'
        ;;
    *)
        printf 'Usage: %s production|staging [--yes] [--dry-run]\n' "$0" >&2
        exit 2
        ;;
esac

readonly APPLICATION_ROOT="$REPOSITORY_ROOT/website"
readonly REMOTE='origin'
readonly SEEDERS=(
    'Database\Seeders\PageSeeder'
    'Database\Seeders\HomePageSeeder'
    'Database\Seeders\GetStartedPageSeeder'
    'Database\Seeders\SocialLinksSeeder'
    'Database\Seeders\StoreProductSeeder'
)

step() { printf '\n%b▶ %s%b\n' "$YELLOW" "$1" "$NC"; }
ok() { printf '%b  ✓ %s%b\n' "$GREEN" "$1" "$NC"; }
fail() { printf '%b  ✗ %s%b\n' "$RED" "$1" "$NC" >&2; return 1; }

configure_node_path() {
    local node_directory

    if command -v node >/dev/null 2>&1 && command -v npm >/dev/null 2>&1; then
        return
    fi

    # cPanel does not add EasyApache's Node.js directory to the PATH used by
    # Git deployment tasks, even when Node.js is installed on the server.
    for node_directory in \
        /opt/cpanel/ea-nodejs24/bin \
        /opt/cpanel/ea-nodejs22/bin \
        /opt/cpanel/ea-nodejs20/bin \
        /opt/cpanel/ea-nodejs18/bin \
        /opt/cpanel/ea-nodejs16/bin \
        "$HOME"/.nvm/versions/node/*/bin
    do
        if [[ -x "$node_directory/node" && -x "$node_directory/npm" ]]; then
            PATH="$node_directory:$PATH"
            export PATH
            return
        fi
    done
}

validate_frontend_assets() {
    local application_root="$1"
    local manifest="$application_root/public/build/manifest.json"

    [[ -s "$manifest" ]] || fail "Missing compiled Vite manifest: $manifest"

    "$PHP_BIN" -r '
        $root = $argv[1];
        $manifest = json_decode(
            file_get_contents($root . "/public/build/manifest.json"),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if ($manifest === []) {
            fwrite(STDERR, "Vite manifest is empty.\n");
            exit(1);
        }

        foreach ($manifest as $entry) {
            $assets = array_merge(
                isset($entry["file"]) ? [$entry["file"]] : [],
                $entry["css"] ?? []
            );

            foreach ($assets as $asset) {
                if (!is_file($root . "/public/build/" . $asset)) {
                    fwrite(STDERR, "Missing compiled Vite asset: " . $asset . "\n");
                    exit(1);
                }
            }
        }
    ' "$application_root"
}

if $DRY_RUN; then
    printf 'Target:           %s\n' "$TARGET"
    printf 'Branch:           %s\n' "$BRANCH"
    printf 'Repository root:  %s\n' "$REPOSITORY_ROOT"
    printf 'Application root: %s\n' "$APPLICATION_ROOT"
    printf 'Health URL:       %s\n' "$HEALTH_URL"
    exit 0
fi

PHASE='preflight'
MAINTENANCE_ACTIVE=false
CANDIDATE_PARENT=''
CANDIDATE_REPOSITORY=''
PREVIOUS_COMMIT='not recorded'

cleanup_candidate() {
    if [[ -n "$CANDIDATE_REPOSITORY" && -d "$CANDIDATE_REPOSITORY" ]]; then
        git -C "$REPOSITORY_ROOT" worktree remove --force "$CANDIDATE_REPOSITORY" >/dev/null 2>&1 || true
    fi

    if [[ -n "$CANDIDATE_PARENT" && -d "$CANDIDATE_PARENT" ]]; then
        rmdir "$CANDIDATE_PARENT" >/dev/null 2>&1 || true
    fi
}

handle_error() {
    local exit_code=$?
    trap - ERR INT TERM
    cleanup_candidate

    printf '\n%bDeployment failed during: %s%b\n' "$RED" "$PHASE" "$NC" >&2
    printf 'Previous live commit: %s\n' "$PREVIOUS_COMMIT" >&2

    if $MAINTENANCE_ACTIVE; then
        printf '%bThe application remains in maintenance mode to avoid serving an inconsistent release.%b\n' "$YELLOW" "$NC" >&2
        printf 'After resolving the problem, bring it online with:\n  cd %q && %q artisan up\n' "$APPLICATION_ROOT" "${PHP_BIN:-php}" >&2
    fi

    exit "$exit_code"
}

trap handle_error ERR INT TERM

step 'Checking server prerequisites'
configure_node_path
for command_name in git php composer curl mktemp sha256sum; do
    command -v "$command_name" >/dev/null 2>&1 || fail "$command_name is required but was not found."
done

readonly PHP_BIN="$(command -v php)"
readonly COMPOSER_BIN="$(command -v composer)"

if command -v node >/dev/null 2>&1 && command -v npm >/dev/null 2>&1; then
    readonly NODE_BIN="$(command -v node)"
    readonly NPM_BIN="$(command -v npm)"
    readonly BUILD_FRONTEND=true
else
    readonly NODE_BIN=''
    readonly NPM_BIN=''
    readonly BUILD_FRONTEND=false
fi

"$PHP_BIN" -r 'exit(version_compare(PHP_VERSION, "8.4.0", ">=") ? 0 : 1);' \
    || fail "PHP 8.4 or newer is required; found $($PHP_BIN -r 'echo PHP_VERSION;')."

[[ -d "$REPOSITORY_ROOT/.git" ]] || fail "Git repository not found at $REPOSITORY_ROOT."
[[ -f "$APPLICATION_ROOT/artisan" ]] || fail "Laravel artisan file not found at $APPLICATION_ROOT."
[[ -f "$APPLICATION_ROOT/.env" ]] || fail "Missing $APPLICATION_ROOT/.env. Create it manually before deployment."
[[ -w "$APPLICATION_ROOT/storage" ]] || fail "$APPLICATION_ROOT/storage is not writable."
[[ -w "$APPLICATION_ROOT/bootstrap/cache" ]] || fail "$APPLICATION_ROOT/bootstrap/cache is not writable."

actual_root="$(git -C "$REPOSITORY_ROOT" rev-parse --show-toplevel)"
[[ "$actual_root" == "$REPOSITORY_ROOT" ]] || fail "Expected repository root $REPOSITORY_ROOT, found $actual_root."

current_branch="$(git -C "$REPOSITORY_ROOT" branch --show-current)"
[[ "$current_branch" == "$BRANCH" ]] || fail "$TARGET must be on branch $BRANCH; currently on ${current_branch:-detached HEAD}."

[[ -z "$(git -C "$REPOSITORY_ROOT" status --porcelain --untracked-files=no)" ]] \
    || fail 'The server has tracked file changes. Commit or restore them before deploying.'

PREVIOUS_COMMIT="$(git -C "$REPOSITORY_ROOT" rev-parse HEAD)"
ENV_CHECKSUM="$(sha256sum "$APPLICATION_ROOT/.env" | awk '{print $1}')"
if $BUILD_FRONTEND; then
    ok "Preflight passed with PHP $($PHP_BIN -r 'echo PHP_VERSION;') and Node $($NODE_BIN --version)"
else
    validate_frontend_assets "$APPLICATION_ROOT"
    ok "Preflight passed with PHP $($PHP_BIN -r 'echo PHP_VERSION;'); using committed Vite assets"
fi

step "Fetching $REMOTE/$BRANCH"
git -C "$REPOSITORY_ROOT" fetch --prune "$REMOTE" "$BRANCH"
readonly RELEASE_COMMIT="$(git -C "$REPOSITORY_ROOT" rev-parse "$REMOTE/$BRANCH")"
ok "Candidate commit: $RELEASE_COMMIT"

PHASE='candidate validation'
step 'Creating isolated candidate release'
CANDIDATE_PARENT="$(mktemp -d "${TMPDIR:-/tmp}/nankov-deploy-${TARGET}.XXXXXX")"
CANDIDATE_REPOSITORY="$CANDIDATE_PARENT/repository"
git -C "$REPOSITORY_ROOT" worktree add --detach "$CANDIDATE_REPOSITORY" "$RELEASE_COMMIT"
readonly CANDIDATE_APPLICATION="$CANDIDATE_REPOSITORY/website"
install -m 600 "$APPLICATION_ROOT/.env" "$CANDIDATE_APPLICATION/.env"

step 'Installing candidate PHP dependencies'
(
    cd "$CANDIDATE_APPLICATION"
    "$COMPOSER_BIN" install --prefer-dist --no-interaction --optimize-autoloader
)

step 'Installing and building candidate frontend assets'
if $BUILD_FRONTEND; then
    (
        cd "$CANDIDATE_APPLICATION"
        "$NPM_BIN" ci --no-audit --no-fund
        "$NPM_BIN" run build
    )
else
    validate_frontend_assets "$CANDIDATE_APPLICATION"
    ok 'Committed candidate frontend assets passed validation'
fi

step 'Running candidate test suite'
(
    cd "$CANDIDATE_APPLICATION"
    "$PHP_BIN" artisan test
    "$PHP_BIN" artisan config:clear
    "$PHP_BIN" artisan route:list >/dev/null
)
ok 'Candidate dependencies, build, tests, and application boot passed'

if [[ "$TARGET" == 'production' ]] && ! $ASSUME_YES; then
    printf '\nDeploy tested commit %s to PRODUCTION? Type production to continue: ' "$RELEASE_COMMIT"
    read -r confirmation
    [[ "$confirmation" == 'production' ]] || fail 'Production deployment cancelled.'
fi

PHASE='maintenance mode'
step 'Enabling maintenance mode'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan down --retry=15
)
MAINTENANCE_ACTIVE=true
ok 'Maintenance mode enabled'

PHASE='source update'
step "Fast-forwarding $BRANCH to the tested commit"
git -C "$REPOSITORY_ROOT" merge --ff-only "$RELEASE_COMMIT"
[[ "$(git -C "$REPOSITORY_ROOT" rev-parse HEAD)" == "$RELEASE_COMMIT" ]] \
    || fail 'Live checkout does not match the tested commit.'
[[ -f "$APPLICATION_ROOT/.env" ]] || fail '.env disappeared during source update.'
[[ "$(sha256sum "$APPLICATION_ROOT/.env" | awk '{print $1}')" == "$ENV_CHECKSUM" ]] \
    || fail '.env changed during deployment; stopping immediately.'
ok 'Source updated and .env preserved'

PHASE='production dependencies'
step 'Installing production PHP dependencies'
(
    cd "$APPLICATION_ROOT"
    "$COMPOSER_BIN" install \
        --no-dev \
        --prefer-dist \
        --optimize-autoloader \
        --no-interaction
)

step 'Installing and building production frontend assets'
if $BUILD_FRONTEND; then
    (
        cd "$APPLICATION_ROOT"
        "$NPM_BIN" ci --no-audit --no-fund
        "$NPM_BIN" run build
    )
else
    validate_frontend_assets "$APPLICATION_ROOT"
    ok 'Committed production frontend assets passed validation'
fi

PHASE='database migration'
step 'Clearing stale caches and running migrations'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan optimize:clear
    "$PHP_BIN" artisan migrate --force
)
ok 'Database migrations completed'

PHASE='database seeders'
step 'Running approved idempotent seeders'
for seeder in "${SEEDERS[@]}"; do
    (
        cd "$APPLICATION_ROOT"
        "$PHP_BIN" artisan db:seed --class="$seeder" --force
    )
done
ok 'Approved seeders completed'

PHASE='application finalization'
step 'Finalizing Laravel assets and caches'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan storage:link --force
    "$PHP_BIN" artisan filament:upgrade
    "$PHP_BIN" artisan sitemap:generate
    "$PHP_BIN" artisan config:cache
    "$PHP_BIN" artisan route:cache
    "$PHP_BIN" artisan view:cache
    "$PHP_BIN" artisan event:cache
    "$PHP_BIN" artisan queue:restart
    "$PHP_BIN" artisan horizon:terminate >/dev/null 2>&1 || true
)

find "$APPLICATION_ROOT/storage" "$APPLICATION_ROOT/bootstrap/cache" -type d -exec chmod 775 {} +
find "$APPLICATION_ROOT/storage" "$APPLICATION_ROOT/bootstrap/cache" -type f -exec chmod 664 {} +

[[ "$(sha256sum "$APPLICATION_ROOT/.env" | awk '{print $1}')" == "$ENV_CHECKSUM" ]] \
    || fail '.env changed during application finalization.'
ok 'Application finalized and .env checksum verified'

PHASE='bringing application online'
step 'Disabling maintenance mode'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan up
)
MAINTENANCE_ACTIVE=false

PHASE='HTTP health check'
step "Checking $HEALTH_URL"
if ! curl --fail --location --silent --show-error --max-time 30 "$HEALTH_URL" >/dev/null; then
    (
        cd "$APPLICATION_ROOT"
        "$PHP_BIN" artisan down --retry=15
    )
    MAINTENANCE_ACTIVE=true
    fail 'Health check failed; application returned to maintenance mode.'
fi

cleanup_candidate
trap - ERR INT TERM

printf '\n%bDeployment complete%b\n' "$GREEN" "$NC"
printf 'Environment: %s\n' "$TARGET"
printf 'Branch:      %s\n' "$BRANCH"
printf 'Previous:    %s\n' "$PREVIOUS_COMMIT"
printf 'Deployed:    %s\n' "$RELEASE_COMMIT"
printf 'Health URL:  %s\n' "$HEALTH_URL"
