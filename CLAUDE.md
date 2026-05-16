# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Personal website and portfolio for Andrej Nankov. The Laravel app lives entirely under `website/` — all artisan commands and composer scripts must be run from there. The repo root holds Docker config and CI/CD only.

## Commands

All commands are run from `website/` unless noted.

```bash
# Start all dev services concurrently (server, queue, logs, vite)
composer dev

# Individual services
php artisan serve
npm run dev
php artisan queue:listen --tries=1
php artisan pail --timeout=0

# Build assets
npm run build

# Tests
php artisan test
php artisan test --filter=DetectBruteForceTest   # single test class
vendor/bin/phpunit tests/Unit/Middleware/DetectBruteForceTest.php

# Code formatting
./vendor/bin/pint

# CRUD scaffolding (dev only)
php artisan make:crud ResourceName

# Queue monitoring dashboard
php artisan horizon

# Shield (Filament RBAC) — run once after fresh install
php artisan shield:setup
php artisan shield:generate --all

# Log monitoring
php artisan pail
```

## Docker

```bash
# From repo root
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan migrate --seed
docker compose exec app npm install && npm run build
```

Services: `app` (Apache/PHP on port 80), `database` (MySQL 5.7 on 3306), `redis` (6379), `database-client` (Adminer on 54320).

## Architecture

### Directory Layout (within `website/`)

- `app/Filament/` — admin panel resources, pages, widgets; auto-discovered via `discoverResources`
- `app/Livewire/` — reactive frontend components and Volt pages
- `app/Http/Middleware/DetectBruteForce.php` — global brute-force/rate-limit guard applied to the `web` middleware group; sends security notifications to Telegram, Slack, and email on threshold breach
- `app/Listeners/FailedLoginListener.php` — wired in `bootstrap/app.php` via `Event::listen(Failed::class, ...)`
- `app/Notifications/SecurityIncident.php` — multi-channel security alert (Telegram, Slack, mail)
- `app/Models/` — standard Eloquent models; `User` has Jetstream profile photo and 2FA columns
- `app/Providers/Filament/AdminPanelProvider.php` — single Filament panel at `/admin` with Shield RBAC, Jetstream profile, log viewer, and auth designer plugins

### Two Filament Panels

- `AdminPanelProvider` — `/admin`, primary content management panel (default)
- `AppPanelProvider` — secondary panel for app-specific views

### Frontend

Blade templates + Livewire 3 components + Volt. Tailwind CSS 3 + DaisyUI (10 themes). Assets compiled by Vite 6. Alpine.js included via Livewire.

### Key Third-Party Packages

| Package | Purpose |
|---|---|
| `filament/filament` ^4.0 | Admin panel |
| `bezhansalleh/filament-shield` | RBAC for Filament |
| `stephenjude/filament-jetstream` | Profile/2FA in Filament |
| `livewire/volt` | Single-file Livewire components |
| `nanorocks/laravel-database-newsletter` | Newsletter subscriber management |
| `nanorocks/laravel-license-manager` | License key management |
| `spatie/laravel-activitylog` | Audit log |
| `panphp/pan` | Analytics (stored in `pan_analytics` table) |
| `ryangjchandler/laravel-cloudflare-turnstile` | CAPTCHA on public forms |
| `laravel/horizon` | Queue monitoring at `/horizon` |
| ~~`husam-tariq/filament-database-schedule`~~ | Removed — no L13 release. Plugin was already disabled in AdminPanelProvider |

### Testing

Tests use SQLite in-memory (configured in `phpunit.xml`). Queue is `sync`, cache is `array`. Feature tests cover auth flows, security middleware, and the brute-force detection system. Security tests are grouped under `tests/Feature/Security/`.

**Known pre-existing test failures (not related to L13 upgrade):**
- `RegistrationTest` — `/register` route is commented out in `routes/auth.php`
- `AuthenticationTest::navigation_menu_can_be_rendered` — `layout.navigation` Volt component is not rendered in the dashboard view
- `ExampleTest::the_application_returns_a_successful_response` — needs `RefreshDatabase` trait; the `pages` table doesn't exist in the SQLite in-memory DB

**L13 testing API changes applied:**
- `Log::fake()` removed; replaced with `Log::spy()` where log assertions are needed
- `Notification::assertSentTo(null, ...)` → `Notification::assertSentOnDemand(...)`
- `Notification::assertNotSentTo(null, ...)` → `Notification::assertNotSentTo(new AnonymousNotifiable, ...)`
- `Notification::sent(null, ...)` → `Notification::sent(new AnonymousNotifiable, ...)`

### CI/CD

GitHub Actions runs PHP Insights on push/PR and deploys to cPanel via FTP sync on pushes to `main`.
