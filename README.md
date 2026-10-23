# Accountancy

An early-stage web app for accountancy practices to track their clients and the status of each client's sync with accounting software: **Xero**, **QuickBooks** and **Sage**.

It's built with [Laravel 11](https://laravel.com) and [Livewire 3](https://livewire.laravel.com), and the app lives in the [`Accountancy/`](Accountancy) directory.

## What it does

The app is a prototype. Client data is hard-coded and the sync to accounting software is simulated. So far it has:

- **Client list** (`App\Livewire\Clientlist`): a table of 15 sample clients (name, email) with a sync status for each of Xero, QuickBooks and Sage. A status is `Not Started`, `In Progress`, `Completed` or `Failed`.
- **Sync action** (`Clientlist::syncClient($clientId, $service)`): a placeholder for the real API integration. For now it gives the client's status for that service a random value.
- **Homepage** (`App\Livewire\Homepage`): the landing page.
- **Navigation bar** (`App\Livewire\NavigatorBar`): a collapsible menu that switches between pages by redirecting to named routes.
- **Layout** (`App\Livewire\AppLayout`): the shared page layout that the other components render into.

## Project structure

```
Accountancy/
├── app/
│   ├── Livewire/          # AppLayout, Clientlist, Homepage, NavigatorBar
│   ├── Models/User.php    # Default Laravel user model
│   └── Providers/
├── bootstrap/
├── config/                # Laravel config, including livewire.php
├── database/              # Default users and cache migrations, factory and seeder
├── composer.json
└── install                # Larafast installer script
```

## Current limitations

- The repository has **no `routes/`, `resources/` (Blade views), `public/` or `tests/` directories**. The Livewire components refer to views (`livewire.clientlist`, `livewire.homepage`, `livewire.navigator-bar`, `livewire.app-layout`) and named routes that aren't committed, so the app won't run until they're added.
- Clients are stored in a hard-coded array, not the database.
- There's no real integration with Xero, QuickBooks or Sage yet: `syncClient` only picks a random status.

## Requirements

- PHP 8.2 or later
- Composer
- SQLite (the default database in `.env.example`)

## Getting started

```bash
cd Accountancy
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

> The app won't serve pages until the missing routes and views are added (see [Current limitations](#current-limitations)).

## Tech stack

| Component | Version |
|-----------|---------|
| PHP | ^8.2 |
| Laravel | ^11.9 |
| Livewire | ^3.5 |
| PHPUnit | ^11.0 |

## License

MIT, as declared in `composer.json`.
