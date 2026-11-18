<?php

namespace App\Repositories;

use App\Models\Employee;

interface EmployeeRepository
{
    /** @return array<int, Employee> */
    public function all(): array;

    public function find(int $id): ?Employee;

    public function findByEmail(string $email): ?Employee;

    public function create(string $firstName, string $lastName, string $email): Employee;

    public function delete(int $id): bool;
}
