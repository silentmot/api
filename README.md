# :rocket: Mardam BackEnd

## :pushpin: Installation
* run `composer install`
* run `php artisan key:generate`
* run `php artisan passport:keys`
* set database credentials in `.env` file
* `group_concat_max_len` by default is `1024`, run `SET GLOBAL group_concat_max_len = 1000000;` in your MySQL server
    * then check with `SHOW VARIABLES LIKE '%group_concat%'` after restart your connection
* set `FRONTEND_URL` in `.env` file
* set `CACHE_DRIVER` and `QUEUE_CONNECTION` to `redis` in `.env` file
* set `PLC_*` keys in `.env` file
* set `AVL_*` keys in `.env` file
* set `TRIVIAL_TIME_AMOUNT` key in `.env` file, by default it's 1 min
* deploy Horizon [details here](https://laravel.com/docs/6.x/horizon#deploying-horizon)
* set cron scheduler on your server [details here](https://laravel.com/docs/6.x/scheduling#introduction)

## :bookmark_tabs: Requirements
* NGINX
* PHP 7.2+
* MySQL 5.7+
* Redis 6+
* Git
* Nice Editor or IDE

## :art: Code Style
It's very important to write clean and nice to read code. so, we tried so hard to force that as much as possible.
Here's some rules you must follow:
* This core follows [PSR-2](https://www.php-fig.org/psr/psr-2/) standard, but very soon will follows [PSR-12](https://www.php-fig.org/psr/psr-12/) standard,
**PLEASE** read them carefully.
* We try to make it nicer and easer to fix through `PHP-CS-Fixer` package, you can read the configurations on `.php_cs` file.
* Please be sensitive about spaces and lines.
* **Don't use tabs**, use spaces.
* The max width per line is **120** char, you can configure your editor or IDE for that.
* Leave empty line at end of every file, you can configure your editor or IDE for that.
* Never ever use PHP closing tag `?>`.
* Don't forget to run the git hook `git config core.hooksPath .githooks` to check your code before every commit / push.

What the git hooks do?
1. Scan your code and fix its style to follow `PSR-2` and `.php_cs` configurations `before every commit`.
2. Scan your code to finding errors through `Larastan` package `before every commit`.
3. Run test units to be sure that all your tests passes `before every push`.

For more details about your code we highly recommended you to run `php artisan insights`.
