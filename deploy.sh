
cp .env.example .env

php artisan key:generate

#run Database Migrations
php artisan migrate:fresh

#seeders
php artisan db:seed
