# tinker

![](https://laravel.com/assets/img/components/logo-tinker.svg)

[![Build Status](https://travis-ci.org/laravel/tinker.svg)](https://travis-ci.org/laravel/tinker) [![Total Downloads](https://poser.pugx.org/laravel/tinker/d/total.svg)](https://packagist.org/packages/laravel/tinker) [![Latest Stable Version](https://poser.pugx.org/laravel/tinker/v/stable.svg)](https://packagist.org/packages/laravel/tinker) [![License](https://poser.pugx.org/laravel/tinker/license.svg)](https://packagist.org/packages/laravel/tinker)

### Introduction

Laravel Tinker is a powerful REPL for the Laravel framework.

### Official Documentation

Documentation for Tinker can be found on the [Laravel website](https://laravel.com/docs/6.x/artisan#tinker).

#### Installation

To get started with Laravel Tinker, simply run:

```
composer require laravel/tinker
```

#### Dispatching Jobs

The `dispatch` helper function and `dispatch` method on the `Dispatchable` class depends on garbage collection to place the job on the queue. Therefore, when using `tinker`, you should use `Bus::dispatch` or `Queue::push` to dispatch jobs.

### Contributing

Thank you for considering contributing to Tinker! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

### Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

### Security Vulnerabilities

Please review [our security policy](https://github.com/laravel/tinker/security/policy) on how to report security vulnerabilities.

### License

Laravel Tinker is open-sourced software licensed under the [MIT license](../framework/LICENSE.md).
