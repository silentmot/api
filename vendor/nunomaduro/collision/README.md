# collision

![Collision logo](https://raw.githubusercontent.com/nunomaduro/collision/stable/docs/logo.png)\
![Collision code example](https://raw.githubusercontent.com/nunomaduro/collision/stable/docs/example.png)

[![Build Status](https://img.shields.io/travis/nunomaduro/collision/stable.svg)](https://travis-ci.org/nunomaduro/collision) [![Quality Score](https://img.shields.io/scrutinizer/g/nunomaduro/collision.svg)](https://scrutinizer-ci.com/g/nunomaduro/collision) [![Coverage](https://img.shields.io/scrutinizer/coverage/g/nunomaduro/collision.svg)](https://scrutinizer-ci.com/g/nunomaduro/collision) [![Total Downloads](https://poser.pugx.org/nunomaduro/collision/d/total.svg)](https://packagist.org/packages/nunomaduro/collision) [![Latest Stable Version](https://poser.pugx.org/nunomaduro/collision/v/stable.svg)](https://packagist.org/packages/nunomaduro/collision) [![License](https://poser.pugx.org/nunomaduro/collision/license.svg)](https://packagist.org/packages/nunomaduro/collision)

### About Collision

Collision was created by, and is maintained by [Nuno Maduro](https://github.com/nunomaduro), and is an error handler framework for console/command-line PHP applications.

* Build on top of [Whoops](https://github.com/filp/whoops).
* Supports [Laravel](https://github.com/laravel/laravel) Artisan & [PHPUnit](https://github.com/sebastianbergmann/phpunit).
* Built with [PHP 7](https://php.net) using modern coding standards.

### Installation & Usage

> **Requires** [**PHP 7.1+**](https://php.net/releases/)

Require Collision using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/collision --dev
```

If you are not using Laravel, you need to register the handler in your code:

```php
(new \NunoMaduro\Collision\Provider)->register();
```

### Lumen adapter

Configure the Collision service provider:

```php
// bootstrap/app.php:
$app->register(\NunoMaduro\Collision\Adapters\Laravel\CollisionServiceProvider::class);
```

### Phpunit adapter

Phpunit must be 7.0 or higher.

Add the following configuration to your `phpunit.xml`:

```xml
    <listeners>
        <listener class="NunoMaduro\Collision\Adapters\Phpunit\Listener" />
    </listeners>
```

### Contributing

Thank you for considering to contribute to Collision. All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

You can have a look at the [CHANGELOG](CHANGELOG.md) for constant updates & detailed information about the changes. You can also follow the twitter account for latest announcements or just come say hi!: [@enunomaduro](https://twitter.com/enunomaduro)

### Support the development

**Do you like this project? Support it by donating**

* PayPal: [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=\_s-xclick\&hosted\_button\_id=66BYDWAT92N6L)
* Patreon: [Donate](https://www.patreon.com/nunomaduro)

### License

Collision is an open-sourced software licensed under the [MIT license](../larastan/LICENSE.md).

Logo by [Caneco](https://twitter.com/caneco).
