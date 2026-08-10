# cPanel deployment

The deployment is run manually from cPanel Terminal. It fetches `main` for production and `develop` for staging, validates the exact remote commit in an isolated Git worktree, and only updates the live checkout after the candidate passes Composer installation, the frontend build, the Laravel tests, and an application boot check.

## Security first

Any SSH private key or passphrase that has been copied into chat, email, or a screenshot is compromised. Deauthorize and delete it from cPanel, remove it from GitHub deploy keys, and do not use it.

Generate a dedicated cPanel-to-GitHub RSA 4096 key called `github_nankov_deploy`. It may have no passphrase so the manual deploy command can run unattended, but it must remain a read-only GitHub deploy key scoped only to `nanorocks/andrej.nankov.mk`. Do not authorize this key for inbound cPanel SSH and never display or copy the private key.

Add only its `.pub` value in GitHub under **Repository settings → Deploy keys**, with write access disabled. Configure `/home/nankovmk/.ssh/config`:

```sshconfig
Host github-nankov
    HostName github.com
    User git
    IdentityFile /home/nankovmk/.ssh/github_nankov_deploy
    IdentitiesOnly yes
```

Verify GitHub's host fingerprint against GitHub's official documentation before accepting it, then test with `ssh -T github-nankov`.

## Repository setup

Production uses:

- Repository: `/home/nankovmk/public_html/cicd_projects/nankov.mk`
- Laravel: `/home/nankovmk/public_html/cicd_projects/nankov.mk/website`
- Document root: `/home/nankovmk/public_html/cicd_projects/nankov.mk/website/public`
- Branch: `main`

Staging uses:

- Repository: `/home/nankovmk/public_html/cicd_projects/test.nankov.mk`
- Laravel: `/home/nankovmk/public_html/cicd_projects/test.nankov.mk/website`
- Document root: `/home/nankovmk/public_html/cicd_projects/test.nankov.mk/website/public`
- Branch: `develop`

Create `develop` from `main` in GitHub before cloning staging. Configure the Git remote in both checkouts as:

```text
git@github-nankov:nanorocks/andrej.nankov.mk.git
```

The deployment refuses to create or modify `.env`. Create `website/.env` manually before the first deployment and set it to mode `600`. Production and staging must use different application keys, databases, cache prefixes, session cookies, queue data, mail settings, and Paddle environments.

For production Paddle checkout, set these values in the production `website/.env`
before running the finalizer:

```dotenv
PADDLE_SANDBOX=false
PADDLE_CLIENT_SIDE_TOKEN=live_...
PADDLE_API_KEY=<production Paddle API key>
PADDLE_WEBHOOK_SECRET=<secret from the active Paddle notification destination>
PADDLE_LIVE_EBOOK_PRICE_ID=pri_01kzj76fhansrpmth540272hzs
PADDLE_WEBHOOK_IP_ALLOWLIST=true
PADDLE_IPS_ENDPOINT=https://api.paddle.com/ips
```

The live price ID above is the active EUR price for the production catalog item.
After deploying the application, run the production-only catalog seeder from the
production Laravel directory:

```bash
PADDLE_LIVE_EBOOK_PRICE_ID=pri_01kzj76fhansrpmth540272hzs php artisan db:seed --class=LiveStoreProductSeeder --force
```

Never run this seeder against staging; staging must retain sandbox Paddle keys
and sandbox price IDs.

## Install the command

From the production Laravel directory:

```bash
chmod 700 deploy.sh scripts/install-cpanel-deployer.sh
bash scripts/install-cpanel-deployer.sh
```

If needed, add `~/bin` to `PATH` as instructed by the installer.

Validate the fixed mappings without deploying:

```bash
deploy-nankov production --dry-run
deploy-nankov staging --dry-run
```

## GitHub Actions deployment over FTPS

Production is deployed over explicit FTPS because Imunify360 blocks cPanel API
requests from dynamic GitHub-hosted runner addresses. The workflow in
`.github/workflows/deployCPanel.yml` installs CI dependencies, runs the Laravel
tests, builds Vite assets, and then incrementally synchronizes the `website`
directory on every push to `main`.
The application and its locked dependencies require PHP 8.4 or newer; select
PHP 8.4 for the domain in cPanel before the first FTPS deployment.

Create a dedicated FTP account in **cPanel → Files → FTP Accounts**. Scope its
directory to the application root exactly:

```text
/home/nankovmk/public_html/cicd_projects/nankov.mk/website
```

Do not use the main cPanel account. In the GitHub repository, open **Settings →
Environments → production → Environment secrets** and create:

- `FTP_SERVER`: the TLS hostname shown by **Configure FTP Client**, without
  `ftp://` and preferably matching the server certificate.
- `FTP_USERNAME`: the complete dedicated FTP username shown by cPanel.
- `FTP_PASSWORD`: the dedicated account's strong password.

The workflow uses explicit FTPS on port 21. Its remote directory is `/` because
the FTP account itself is jailed to the Laravel application root. It never
uploads or deletes `.env`, runtime `storage`, the public storage link, local
authentication files, tests, Node dependencies, or Composer's `vendor`
directory. Never enable the action's `dangerous-clean-slate` option.

FTPS cannot execute server commands. After a deployment containing database
migrations or cache-sensitive changes, run the guarded application finalizer
from cPanel Terminal:

```bash
cd /home/nankovmk/public_html/cicd_projects/nankov.mk/website
bash scripts/finalize-ftp-deployment.sh
```

The finalizer checks PHP, Composer, `.env`, and writable runtime directories.
It enables maintenance mode when an existing `vendor` installation can boot
Laravel, installs the exact locked production dependencies with Composer, runs
migrations, rebuilds Laravel caches and generated assets, restarts queue
workers, and brings the site online. If a command fails after maintenance mode
begins, it intentionally leaves the application offline and prints the
recovery command.

The workflow also supports a manual run from **GitHub → Actions → Deploy
production to cPanel over FTPS → Run workflow**.

## Deploy manually

Deploy staging:

```bash
deploy-nankov staging
```

Deploy production (requires typing `production` to confirm):

```bash
deploy-nankov production
```

`--yes` skips the production confirmation and should be reserved for an already controlled automation context.

The script uses `composer install` and `npm ci`; it never updates dependency versions during deployment. Add future production-safe seeders to the explicit `SEEDERS` array in `deploy.sh`. Every listed seeder must be idempotent.

If a failure occurs after maintenance mode begins, the site intentionally remains unavailable rather than serving a partially deployed release. The error output identifies the failed phase and prints the command needed to bring the application online after the problem is resolved. Database migrations are never rolled back automatically; take a cPanel database backup before production releases containing migrations.

## Cron and queues

Create a separate scheduler cron for each environment:

```cron
* * * * * cd /home/nankovmk/public_html/cicd_projects/nankov.mk/website && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
* * * * * cd /home/nankovmk/public_html/cicd_projects/test.nankov.mk/website && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

Use cPanel-supported Supervisor or Horizon for long-running workers when available. Otherwise configure separate locked cron workers for production and staging. The deploy script signals both Laravel queue workers and Horizon to restart after a successful release.
