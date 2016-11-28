# sale-ticket
this demo is for sale-ticket store by laravel.

#require:
1. php5.5.9+
2. apache or nginx
3. mysql 5.6+
4. [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)


#step:
1. clone the code.
2. install the vender.

```
composer install
```

3. chmod 0777 storage

```
chomod -R 0777 storage
```

4. rewirite the apache.

```
<VirtualHost *>
ServerAdmin webmaster@localhost
DocumentRoot "_yourdir_/sale-ticket/public"

<Directory "_yourdir_/sale-ticket/public" >
        Options Indexes FollowSymLinks
        AllowOverride All
        Allow from all
        Require all granted
</Directory>

ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

5. eidt .env and

```
APP_ENV=production
APP_DEBUG=false
APP_URL=_your url_

DB_DATABASE=sale_ticket
DB_USERNAME=root
DB_PASSWORD=_your_password_
```

6. run step:

```
create db in mysql
php artisan migrate:refresh

/*
file: database/seeds/UsersTableSeeder.php
change the admin password.
*/

php artisan db:seed
```
