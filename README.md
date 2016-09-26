Yii 2 Based kinopoisk.ru parser
============================

Parses first page of kinopoisk.ru search results for given year.

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Clone repository to local directory and change current directory to it.

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following commands:

~~~
php composer.phar install --no-dev
~~~

Then configure your database as described below and run:

~~~
php yii migrate --interactive=0
php yii serve
~~~

Now you should be able to access the application through the following URL.

~~~
http://localhost:8080/
~~~

If you want to serve this application for other users, configure your web server
as described here: 
~~~
http://www.yiiframework.com/doc-2.0/guide-start-installation.html#configuring-web-servers
~~~


CONFIGURATION
-------------

### Database

Copy the file `config/db.sample.php` to `config/db.php`.
Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
