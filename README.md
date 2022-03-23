#Digital Marketing landing page

## Table of contents
* General info
* Technologies
* Setup
* Project Images

## General info 
This project is simple landing page, with possibility to visit different sections from navigation bar.
Clicking on SIGN UP opens sign up form. After submission users data are stored in database.

## Technologies
Project is created with:
* PHP 7.4
* HTML5
* SCSS
* JavaScript ES6

## Setup
To run this project, install Composer packages:

```
$ composer require nikic/fast-route
$ composer require doctrine/dbal
$ composer require twig/twig
```
Documentation: <br>
* [Nikic/Fast-route](https://github.com/nikic/FastRoute) - request router
* [Doctrine/Dbal](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/) - database abstraction layer
* [Twig](https://twig.symfony.com/doc/3.x/) - template language for PHP


Database: <br>
[Database](app/Database.php) - provide connection parameters - 'dbname', 'user', 'password' <br>
[Database Schema ](dump.sql) can be found here

##Page Images
![Large screen](C:\Users\agnes\large_screen.png)
![Mobile](C:\Users\agnes\mobile_screen.png)
