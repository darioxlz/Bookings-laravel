# Laravel API RESTful Bookings facilities

### _Using Laravel 8, PostgreSQL 12, JWT._

1. Clone this repo
2. Run ```composer install```
3. Configure your database credentials in ```.env``` file
4. Create database ```clubdata``` in PostgreSQL Server
5. Run ```php artisan migrate:fresh --seed```
6. Run ```composer test```
7. Run ```php artisan serve```
8. Use one API REST Client of your preference to make the requests. Check ```php artisan route:list```

Take a look to documentation
https://documenter.getpostman.com/view/5958984/TWDcGadW

Take a look to database diagram entity-relation

![ER Diagram](https://raw.githubusercontent.com/josevenezuelapadron/Bookings-laravel/master/clubdata.PNG)
