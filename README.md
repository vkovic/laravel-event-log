# Laravel Event Log

[![Build](https://api.travis-ci.org/vkovic/laravel-event-log.svg?branch=master)](https://travis-ci.org/vkovic/laravel-event-log)
[![Downloads](https://poser.pugx.org/vkovic/laravel-event-log/downloads)](https://packagist.org/packages/vkovic/laravel-event-log)
[![Stable](https://poser.pugx.org/vkovic/laravel-event-log/v/stable)](https://packagist.org/packages/vkovic/laravel-event-log)
[![License](https://poser.pugx.org/vkovic/laravel-event-log/license)](https://packagist.org/packages/vkovic/laravel-event-log)

### Easy way to log user created events

Lorem ipsum

---

## Compatibility

The package is compatible with Laravel versions `5.5`, `5.6`, `5.7` and `5.8`.

## Installation

Install the package via composer:

```bash
composer require vkovic/laravel-event-log
```

Run migrations to create table which will be used to store event logs:

```bash
php artisan migrate
```

## Usage

Lorem ipsum

## Contributing

If you plan to modify this Laravel package you should run tests that comes with it.
Easiest way to accomplish this would be with `Docker`, `docker-compose` and `phpunit`.

First, we need to initialize Docker containers:

```bash
docker-compose up -d
```

After that, we can run tests and watch the output:

```bash
docker-compose exec app vendor/bin/phpunit
```