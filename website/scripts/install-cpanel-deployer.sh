#!/usr/bin/env bash

set -Eeuo pipefail

readonly BIN_DIRECTORY='/home/nankovmk/bin'
readonly LAUNCHER="$BIN_DIRECTORY/deploy-nankov"

mkdir -p "$BIN_DIRECTORY"

cat > "$LAUNCHER" <<'LAUNCHER'
#!/usr/bin/env bash
set -Eeuo pipefail

exec /home/nankovmk/public_html/cicd_projects/nankov.mk/website/deploy.sh "$@"
LAUNCHER

chmod 700 "$LAUNCHER"

printf 'Installed %s\n' "$LAUNCHER"
printf 'If ~/bin is not already on PATH, add this line to ~/.bashrc:\n'
printf 'export PATH="$HOME/bin:$PATH"\n'
printf 'Then reload the shell with: source ~/.bashrc\n'

