# cPanel deployment

## Environment map

| Environment | Branch | Deployment | Application root |
| --- | --- | --- | --- |
| Production | `main` | GitHub Actions over FTPS | `/home/nankovmk/public_html/cicd_projects/nankov.mk` |
| Test | `develop` | GitHub Actions over FTPS | FTP account jail |
| Stage | `stage` | Local `deploy-stage.sh` over cPanel API | `/home/nankovmk/public_html/cicd_projects/stage.nankov.mk` |

The stage domain document root must be:

```text
/home/nankovmk/public_html/cicd_projects/stage.nankov.mk/public
```

## Instant local stage deployment

Run the repository-root `deploy-stage.sh` command from a clean, pushed
`stage` branch. It refuses any other branch and verifies that local `HEAD`
exactly matches `origin/stage`.

The command performs the complete release process:

1. authenticates to cPanel using a temporary API token;
2. verifies or provisions `stage.nankov.mk` with the correct document root;
3. validates that the stage environment cannot use test or production-like
   settings;
4. creates an isolated Git archive, installs locked dependencies, builds Vite
   assets, and runs the Laravel test suite locally with a 512 MB PHP memory
   limit;
5. packages the exact production Composer dependencies and compiled assets;
6. uploads and extracts the artifact through cPanel's file APIs;
7. runs migrations, idempotent seeders, storage linking, cache rebuilding,
   sitemap generation, and worker restarts through a random-token-protected,
   single-use deployment gateway; and
8. removes temporary server files and verifies `/up` and `/` over HTTPS.

The cPanel API does not provide general shell execution. The single-use PHP
gateway is therefore required to boot Laravel and invoke the audited Artisan
commands. It accepts only an authenticated `POST` on the stage hostname and
deletes itself after the request.

### First deployment

Create a temporary cPanel API token, then let the command provision a unique
stage database and a local, Git-ignored environment file:

```bash
read -rsp 'cPanel token: ' CPANEL_API_TOKEN; export CPANEL_API_TOKEN; echo
./deploy-stage.sh --provision --bootstrap-env website/.env.stage.local
unset CPANEL_API_TOKEN
```

`website/.env.stage.local` is mode `0600` and ignored by Git. Keep it in a
secure local backup because it contains the generated database password and
application key. The generated environment uses:

- `APP_ENV=staging` and `APP_DEBUG=false`;
- `APP_URL=https://stage.nankov.mk`;
- an isolated cPanel database and database user;
- stage-specific session and cache namespaces;
- log-only mail; and
- Paddle sandbox mode.

If an independently managed environment file already exists, use it instead:

```bash
./deploy-stage.sh --provision --env-file /absolute/path/to/stage.env
```

It must pass the same isolation checks. In particular, the database and user
names must include `stage` or `stg`, and the session cookie and cache prefix
must be stage-specific.

### Later deployments

The remote `.env` is preserved, so a normal stage release is:

```bash
read -rsp 'cPanel token: ' CPANEL_API_TOKEN; export CPANEL_API_TOKEN; echo
./deploy-stage.sh
unset CPANEL_API_TOKEN
```

The token is read from the environment or prompted without echo and is never
written into the repository. Revoke temporary cPanel API tokens after use.

## Production and test GitHub Actions

`.github/workflows/deployCPanel.yml` deploys `main` to production, while
`.github/workflows/deployTest.yml` deploys `develop` to test. Both build and
test the Laravel application before using explicit FTPS on port 21. Their FTP
accounts must be jailed to their intended application roots.

The workflows intentionally preserve `.env`, runtime storage, Composer
`vendor`, and other server-only files. FTPS cannot run Artisan commands; after
a production or test release containing migrations or cache-sensitive changes,
run the guarded `website/scripts/finalize-ftp-deployment.sh` from cPanel
Terminal in that application's root.

Never commit cPanel tokens, FTP passwords, `.env` files, private keys, or
`auth.json`.
