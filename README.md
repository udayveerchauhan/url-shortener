# Laravel URL Shortener Service

A company-aware URL shortening service built using Laravel 11, MySQL, Breeze-style authentication, and Spatie Laravel Permission.

## Features

- Company and user relationship model
- Role-based authorization using Spatie Permission
- Invite user workflow with policy-driven business rules
- Short URL management with automatic unique code generation
- Public URL resolution disabled by design
- Policy-based access control for SuperAdmin, Admin, Member
- PHPUnit feature tests covering authorization and public resolution

## Installation

git remote add origin https://github.com/udayveerchauhan/url-shortener.git
git branch -M main
git push -u origin main

1. Install dependencies

```bash
composer install
```

2. Copy environment variables and set database credentials

```bash
cp .env.example .env
```

3. Generate application key

```bash
php artisan key:generate
```

4. Configure your `.env` database values for MySQL

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Database setup

Run migrations and seed default data:

```bash
php artisan migrate --seed
```

## Default seeded user

The seeder creates a SuperAdmin user:

- Email: `superadmin@example.com`
- Password: `password`

Execute the mentioned command 
`npm i`
`npm run build`

## Testing

Run the feature tests:

```bash
php artisan test
```

## Routes

- `GET /` — welcome page
- `GET /login` — login page
- `POST /login` — authenticate
- `POST /logout` — logout
- `GET /short-urls` — short URL index
- `GET /short-urls/create` — create form
- `POST /short-urls` — create short URL
- `DELETE /short-urls/{short_url}` — delete short URL
- `GET /invitations` — invitation list
- `GET /invitations/create` — invite form
- `POST /invitations` — invite user
- `GET /s/{code}` — public short URL resolution (returns 403)

## Architecture notes

- Policies are used for all invitation and short URL access rules.
- `App\Services\ShortUrlService` generates unique short url
- The `InviteUserRequest` and `StoreShortUrlRequest` objects validate requests and authorize operations.
- Role seeding and a raw SQL SuperAdmin insertion are implemented in database seeders.