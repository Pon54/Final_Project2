Admin development notes

Quickstart (local)

1) Start dev server:

   cd C:\Final_Project
   php -S 127.0.0.1:8000 -t public

2) Seed admin user (safe: seeder checks for admin table):

   php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder
   php artisan db:seed --class=Database\\Seeders\\SampleDataSeeder
   # If you recently added seeders or created/edited seeder files, run composer dump-autoload
   # so the classes are discoverable by artisan before running seed commands.
   composer dump-autoload

   php artisan db:seed --class=Database\\Seeders\\PageSeeder

   Default seeded admin: admin / admin123 (legacy md5 stored)

3) Log in: Open http://127.0.0.1:8000/admin and sign in with the seeded admin credentials.

Session driver (optional)

- If you want to store sessions in the database, run the migration and set .env:

   php artisan migrate

- Then set in your .env:

   SESSION_DRIVER=database

- A migration to create a `sessions` table is included at `database/migrations/2025_10_25_000000_create_sessions_table.php`.

Running tests

- There are several lightweight feature tests in `tests/Feature` which assume legacy tables may be missing and will skip or use session emulation appropriately.

  php artisan test --filter AdminCrudTest -v

Notes & safety

- Seeders are defensive and will skip if legacy tables aren't present. Always run seeders on a dev DB or backup first.
- Admin auth currently uses the legacy `admin` table and session('alogin'). If you want I can migrate to a Laravel-native `admins` guard with bcrypt hashed passwords.

Next suggested steps

- Harden admin auth (migrate to Laravel guard). 
- Expand tests to cover CRUD create/update/delete flows with dedicated test database fixtures.
- Optional: enable database sessions by setting SESSION_DRIVER=database and migrating.
