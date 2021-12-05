# ArtDeck

It's sort of like a booru but for *all* the media. Upload images, videos, audio, text, etc. and tag and organize it all.

## Requirements

- PHP 8+
- MySQL, SQLite, or some other Laravel-compatible RDBMS
- nginx, Apache, or some other web server with rewrite support

If installing from source:

- PHP Composer
- Latest Node.js LTS

## Installation

Complete releases aren't yet available, but installation from source is fairly straightforward. Start by downloading or cloning the repository, then point your web server to the `artdeck/public` directory and enable handling of PHP files.

Then, from your `artdeck` directory:

```bash
composer install
npm ci
npm run production
php artisan storage:link
```

Create a database on your server (MySQL, MariaDB, Postgres, etc.). If you'd prefer to use SQLite, create an empty file where you'd like your database stored (for example `./database/database.sqlite`).

Copy the `.env.example` file to `.env`, and add the configuration for your site name, URL, and database. Carefully consider and set the `ALLOW_REGISTRATION` and `ALLOW_GUESTS` values, as these will affect your moderation efforts, etc.

Once everything is configured in your `.env` file:

```bash
php artisan migrate
```

From here your site should be ready to go. The first user that registers will be an administrator by default, so do that now. If you disabled registration, you can run `php artisan user:add` from the `artdeck` directory to create a user.
