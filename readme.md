

## Requirements:

```
- PHP >= ^7.3|^8.0 (S-Cart 6.x)
- PHP >= ^8.0.2 (S-Cart 7.x)
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
```

## Installation & configuration:

<b>How to map your domain to s-cart? <a href="https://s-cart.org/en/docs/master/installation.html">CLICK HERE</a></b>

**Step1: Install last version S-cart**

Option 1: **From composer**
```
composer create-project s-cart/s-cart
```

Option 2: **From github**
```
git clone https://github.com/s-cart/s-cart.git
```
Then, install vendor:
```
composer install
```

**Step2: Set writable permissions for the following directories:**

- <code>storage</code>
- <code>vendor</code>
- <code>public/data</code>
- <code>bootstrap/cache</code>
- <code>app/Plugins</code>


**Step3: Create database**
```
- Create a new database. Example database name is "s-cart"
```

**Step4: Install**


Option 2: **Manual installation**

If installing with link "install.php" unsuccessful, you can install it manually below.
```
1: Create new database, then import file /vendor/s-cart/core/src/DB/s-cart-yyyy-mm-dd.sql to database.

3: Copy file .env.example to .env if file .env not exist.
4: Generate API key if APP_KEY is null. 
- Use command "php artisan key:generate"
5: Generates the encryption keys
  Use command "php artisan passport:keys"
6: Config value of file .env:
- APP_DEBUG=false (Set "false" is security)
- DB_HOST=127.0.0.1 (Database host)
- DB_PORT=3306 (Database port)
- DB_DATABASE=s-cart (Database name)
- DB_USERNAME=root (User name use database)
- DB_PASSWORD= (Password connect to database)
- APP_URL=http://localhost (Your url)
- ADMIN_PREFIX=sc_admin (Path to admin)
- DB_PREFIX=sc_ (Must be "sc_" because it is fixed in the .sql file)
```

**Step5: Install completed**

- Access to url admin: <b>your-domain/sc_admin</b>.
- User/pass <code><b>admin</b>/<b>admin</b></code>

More detail for installation: <a href="https://s-cart.org/en/docs/master/installation.html">HERE</a>

## Useful information:

To view S-Cart version information

`php artisan sc:info`


d.

To create a plugin:

`php artisan sc:make plugin  --name=Group\PluginName`

Detail: <a href="https://s-cart.org/en/docs/master/how-to-install-module-extension.html">HERE</a>

Library of free plugins for S-Cart: <a href="https://s-cart.org/en/plugin.html">HERE</a>

To create data backup file (The sql file is stored in storage/backups):

`php artisan sc:backup --path=abc.sql`

To recover data:

`php artisan sc:restore --path=abc.sql`

To manually customize the admin page (<code>resources/views/admin + config/admin.php</code>):

`php artisan sc:customize admin`

This command will create new directories `resources/views/admin` and file `config/admin.php`
After set the value `customize=true` in `config/admin.php` you can modify template admin. 

To manually customize file config validation (<code>config/validation.php</code>):

`php artisan sc:customize validation`

More detail: https://s-cart.org/en/docs/master

## Funding and supporting the project

Please visit the <a href="https://s-cart.org/en/license.html" target="_blank">S-Cart</a>

## Security Vulnerabilities:

If you discover a security vulnerability within S-Cart ecommerce, please send an e-mail to Lanh Le via lanhktc@gmail.com. All security vulnerabilities will be promptly addressed.

## License:


