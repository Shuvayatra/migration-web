# Shuvayatra | शुभयात्रा CMS  

## Install

Shuvayatra cms can be cloned from github repository and installed. Following the procedure given below:

* git clone git@github.com:Shuvayatra/migration-web.git
* use https if permission denied `git clone https://github.com/Shuvayatra/migration-web.git`
* change directory by `cd migration-web`
* install the application dependencies using command: `composer install`
* copy .env.example to .env and update your the database configurations
* give write permission to the storage folder using `chmod -R 777 storage`
* run migration using `php artisan migrate`
* seed dummy data using `php artisan db:seed`
* generate cipher key using `php artisan key:generate`
* make a directory `uploads` inside `public` and give write permission to it
* start development server `php artisan serve`
* run `php artisan nrna:acl-setup` for to create user
* access `localhost:8000` from browser

## Framework

The application is written in PHP based on the [Laravel](http://laravel.com) framework, current version of Laravel
used for this project is 5.1.*.


## Tools and packages

This application uses many tools and packages, the packages can
be seen in the [composer.json](https://github.com/Shuvayatra/migration-web/blob/master/composer.json) file.

Some major PHP packages used are listed below:

* [zizaco/entrust](https://packagist.org/packages/zizaco/entrust) - for user roles and permission
* [chrisbjr/api-guard](https://packagist.org/packages/chrisbjr/api-guard) - for authenticating APIs with API keys 

## Structure

The application is structured in a very simple way in `app\Nrna` folder.



