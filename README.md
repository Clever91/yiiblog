<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii Blog Template</h1>
    <br>
</p>

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Clone project to github/gitlab

~~~
git clone this_repository
~~~

### Set web folder

You can set domain

~~~
/to/your/path/yiiblog/web
~~~

in folder

### Install database 

1. set name of database `config/web.php` file: 

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yiiblog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
],
```

2. run migration command to domain root folder

~~~
yii migrate up
~~~

### i18n

run message command to domain root folder

~~~
yii message/extract @app/config/i18n.php
~~~
