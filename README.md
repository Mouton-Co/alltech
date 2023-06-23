Dependancies:

php 8^
node 18^
composer
Run the following console commands:

composer i
npm i
npm run build (npm run dev - for continues watch)
Copy .env.example over to .env Setup database details in .env

Create database:

php artisan migrate:fresh --seed