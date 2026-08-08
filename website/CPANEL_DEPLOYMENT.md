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

- Repository: `/home/nankovmk/public_html/cicd_projects/stage.nankov.mk`
- Laravel: `/home/nankovmk/public_html/cicd_projects/stage.nankov.mk/website`
- Document root: `/home/nankovmk/public_html/cicd_projects/stage.nankov.mk/website/public`
- Branch: `develop`

Create `develop` from `main` in GitHub before cloning staging. Configure the Git remote in both checkouts as:

```text
git@github-nankov:nanorocks/andrej.nankov.mk.git
```

The deployment refuses to create or modify `.env`. Create `website/.env` manually before the first deployment and set it to mode `600`. Production and staging must use different application keys, databases, cache prefixes, session cookies, queue data, mail settings, and Paddle environments.

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

## Deploy

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
* * * * * cd /home/nankovmk/public_html/cicd_projects/stage.nankov.mk/website && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

Use cPanel-supported Supervisor or Horizon for long-running workers when available. Otherwise configure separate locked cron workers for production and staging. The deploy script signals both Laravel queue workers and Horizon to restart after a successful release.
