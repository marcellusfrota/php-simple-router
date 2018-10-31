
# php-simple-router :construction:

**Version 1.2.0** | **Under construction** :construction:

A system for implementing routes in your project.

Feel free to contribute.

## Features
- Supports Methods `GET`, `POST`, `PUT`, `DELETE`

## Prerequisites/Requirements
- PHP >= 7.0

## Usage
You must define your routines in the file `/config/routes.php`, after you just set your controller access uri and your view. All files like autoload and routes are ranger in the `bootstrap.php` file where the `public/index.php` the imcopora.
```php
<?php

use App\Router;
$router = new  Router();

// Define your routes
// ...
$router->get('uri', 'controller@view')
$router->put('uri/boo', 'controller@view')


```
##   Local testing
Inside the project root you can use the php inline server or configure a .htaccess file pointing to the public/

using php server:
```php
php -S localhost:8000 -t public/
```