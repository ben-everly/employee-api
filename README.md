# Employee API

A small RESTful API for managing employees, built with PHP 8.2 and Laravel 10.

## Requirements

- PHP 8.2
- Composer

## Setup

```sh
composer install
cp .env.example .env
php artisan key:generate
```

## Run

```sh
php artisan serve
```

The API is available at `http://localhost:8000/api/employees`.

## Test

```sh
php artisan test
```
