# Wirechat (Laravel)

Small setup guide to run this project locally.

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+ and npm
- MySQL (or compatible database)

## 1) Install dependencies

From the `wirechat` folder:

```bash
composer install
npm install
```

## 2) Environment setup

If needed, create `.env` from example:

```bash
copy .env.example .env
php artisan key:generate
```

Then set DB values in `.env`:

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## 3) Database

```bash
php artisan migrate
```

## 4) Create a login user

Use this one-liner (non-interactive):

```bash
php artisan tinker --execute="App\\Models\\User::updateOrCreate(['email'=>'admin@example.com'],['name'=>'Admin','password'=>bcrypt('password')]);"
```

## 5) Run the app

Use separate terminals:

```bash
php artisan serve
```

```bash
npm run dev
```

Optional (recommended for realtime):

```bash
php artisan reverb:start
```

## 6) Open UI

- Login: `http://localhost:8000/login`
- Chat UI: `http://localhost:8000/chats`

Default test credentials:

- Email: `admin@example.com`
- Password: `password`

## Optional demo chat seed

Create a second user and one starter conversation:

```bash
php artisan tinker --execute="App\\Models\\User::updateOrCreate(['email'=>'demo@example.com'],['name'=>'Demo User','password'=>bcrypt('password')]); App\\Models\\User::where('email','admin@example.com')->first()->createConversationWith(App\\Models\\User::where('email','demo@example.com')->first(),'Hi Demo, this is the first message.');"
```
