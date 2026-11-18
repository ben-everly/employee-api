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

## Endpoints

| Method | Path                  | Success | Errors |
| ------ | --------------------- | ------- | ------ |
| GET    | `/api/employees`      | 200     |        |
| GET    | `/api/employees/{id}` | 200     | 404    |
| POST   | `/api/employees`      | 201     | 422    |
| DELETE | `/api/employees/{id}` | 204     | 404    |

```sh
curl --json '{"firstName": "Ben", "lastName": "Everly", "email": "ben@example.com"}' \
  http://localhost:8000/api/employees
```

## Design

| Class                        | Responsibility                                            |
| ---------------------------- | --------------------------------------------------------- |
| `EmployeeController`         | HTTP only: delegates to the repository, returns responses |
| `StoreEmployeeRequest`       | Validates new employee data                               |
| `UniqueEmployeeEmail`        | Validation rule rejecting duplicate emails                |
| `EmployeeResource`           | Shapes the JSON response                                  |
| `EmployeeRepository`         | Data-access interface                                     |
| `InMemoryEmployeeRepository` | In-memory implementation, bound as a singleton            |
| `Employee`                   | Readonly value object (not Eloquent)                      |
| `EmployeeNotFoundException`  | Renders a 404 for missing employees                       |

## Assumptions

- Data is stored in memory per the spec, so it resets on every request. Two
  employees are seeded so all the endpoints can be exercised.
