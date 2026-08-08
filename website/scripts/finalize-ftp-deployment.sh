#!/usr/bin/env bash

# Finalize a Laravel release after GitHub Actions uploads it over FTPS.
# Usage: bash scripts/finalize-ftp-deployment.sh

set -Eeuo pipefail

readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly RED='\033[0;31m'
readonly NC='\033[0m'

readonly SCRIPT_DIRECTORY="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"
readonly APPLICATION_ROOT="$(cd -- "$SCRIPT_DIRECTORY/.." && pwd -P)"

PHASE='preflight'
MAINTENANCE_ACTIVE=false

step() { printf '\n%b▶ %s%b\n' "$YELLOW" "$1" "$NC"; }
ok() { printf '%b  ✓ %s%b\n' "$GREEN" "$1" "$NC"; }
fail() { printf '%b  ✗ %s%b\n' "$RED" "$1" "$NC" >&2; return 1; }

handle_error() {
    local exit_code=$?
    trap - ERR INT TERM

    printf '\n%bFinalization failed during: %s%b\n' "$RED" "$PHASE" "$NC" >&2

    if $MAINTENANCE_ACTIVE; then
        printf '%bThe application remains in maintenance mode.%b\n' "$YELLOW" "$NC" >&2
        printf 'After resolving the problem, bring it online with:\n'
        printf '  cd %q && %q artisan up\n' "$APPLICATION_ROOT" "${PHP_BIN:-php}" >&2
    fi

    exit "$exit_code"
}

trap handle_error ERR INT TERM

step 'Checking Laravel deployment prerequisites'
for command_name in php; do
    command -v "$command_name" >/dev/null 2>&1 \
        || fail "$command_name is required but was not found."
done

readonly PHP_BIN="$(command -v php)"

[[ -f "$APPLICATION_ROOT/artisan" ]] \
    || fail "Laravel artisan file not found at $APPLICATION_ROOT."
[[ -f "$APPLICATION_ROOT/.env" ]] \
    || fail "Missing $APPLICATION_ROOT/.env."
[[ -f "$APPLICATION_ROOT/vendor/autoload.php" ]] \
    || fail 'Composer dependencies are missing from vendor.'
[[ -w "$APPLICATION_ROOT/storage" ]] \
    || fail "$APPLICATION_ROOT/storage is not writable."
[[ -w "$APPLICATION_ROOT/bootstrap/cache" ]] \
    || fail "$APPLICATION_ROOT/bootstrap/cache is not writable."

"$PHP_BIN" -r 'exit(version_compare(PHP_VERSION, "8.4.0", ">=") ? 0 : 1);' \
    || fail "PHP 8.4 or newer is required; found $($PHP_BIN -r 'echo PHP_VERSION;')."
ok "Preflight passed with PHP $($PHP_BIN -r 'echo PHP_VERSION;')"

PHASE='maintenance mode'
step 'Enabling maintenance mode'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan down --retry=15
)
MAINTENANCE_ACTIVE=true
ok 'Maintenance mode enabled'

PHASE='database migration'
step 'Clearing stale caches and running migrations'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan optimize:clear
    "$PHP_BIN" artisan migrate --force
)
ok 'Database migrations completed'

PHASE='application finalization'
step 'Rebuilding Laravel links and caches'
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
ok 'Laravel links, assets, caches, and workers finalized'

PHASE='bringing application online'
step 'Disabling maintenance mode'
(
    cd "$APPLICATION_ROOT"
    "$PHP_BIN" artisan up
)
MAINTENANCE_ACTIVE=false

trap - ERR INT TERM
printf '\n%bFTP deployment finalization complete%b\n' "$GREEN" "$NC"
