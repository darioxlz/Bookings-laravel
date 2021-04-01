# Laravel API RESTful Bookings facilities

### _Using Laravel 8, PostgreSQL 12, JWT._

1. Clone this repo
2. Run `composer install`
3. Create a `.env` file and copy `.env.example` in it
4. Configure your database credentials in `.env` file
5. Create database `clubdata-api` in PostgreSQL Server
6. Run `php artisan key:generate`
7. Run `php artisan jwt:secret`
8. Run `php artisan migrate:fresh --seed`
9. Run `composer test`
10. Check `php artisan route:list`
11. Run `php artisan serve`

Take a look to documentation
https://documenter.getpostman.com/view/5958984/TWDcGadW

Take a look to database diagram entity-relation

![ER Diagram](https://raw.githubusercontent.com/josevenezuelapadron/Bookings-laravel/master/clubdata.PNG)
