# Accountancy

An early-stage web app for accountancy practices to track their clients and the status of each client's sync with accounting software: **Xero**, **QuickBooks** and **Sage**.

It's built with [Laravel 11](https://laravel.com) and [Livewire 3](https://livewire.laravel.com), and the app lives in the [`Accountancy/`](Accountancy) directory.

## What it does

The app is a prototype. Client data is hard-coded and syncing with the accounting software is a placeholder: nothing is sent to or read from Xero, QuickBooks or Sage yet. So far it has:

- **Client list** (`/clients`, `App\Livewire\Clientlist`): a table of 15 sample clients with a sync status for each of Xero, QuickBooks and Sage (`Not Started`, `In Progress`, `Completed` or `Failed`).
- **Push contact**: sends a client to the accounting software as a contact. For now it always succeeds and marks that service `Completed`.
- **Pull invoices**: fetches a client's invoices and outstanding balance. For now it returns made-up figures, which are shown under the status.
- **Homepage** (`/`, `App\Livewire\Homepage`) and a collapsible **navigation bar** (`App\Livewire\NavigatorBar`).

## How syncing is wired

Each accounting service is a class that implements `App\Services\Accounting\AccountingProvider`, which has two methods: `pushContact()` and `pullFinancials()`. `config/accounting.php` lists the services and the class each one uses. All three use `PlaceholderProvider` for now. To build a real integration, write a class that implements the interface and point that service at it in the config.

## Project structure

```
Accountancy/
├── app/
│   ├── Livewire/              # Clientlist, Homepage, NavigatorBar, AppLayout
│   └── Services/Accounting/   # AccountingProvider interface, PlaceholderProvider
├── config/accounting.php      # Which services exist and which class each uses
├── resources/views/livewire/  # Page layout and component views (Tailwind CSS)
├── routes/web.php             # / and /clients
└── tests/Feature/             # Page and sync tests
```

## Current limitations

- Clients are stored in a hard-coded array, not the database, so changes are lost when the page reloads.
- Push contact and Pull invoices are placeholders (see above).
- There are no user accounts or logins yet.

## Requirements

- PHP 8.2 or later
- Composer
- Node.js and npm (to build the CSS and JavaScript)
- SQLite (the default database in `.env.example`)

## Getting started

```bash
cd Accountancy
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Then open http://127.0.0.1:8000. Run the tests with `php artisan test`.

## Tech stack

| Component | Version |
|-----------|---------|
| PHP | ^8.2 |
| Laravel | ^11.9 |
| Livewire | ^3.5 |
| Tailwind CSS | ^3.4 |
| PHPUnit | ^11.0 |

## License

MIT, as declared in `composer.json`.
