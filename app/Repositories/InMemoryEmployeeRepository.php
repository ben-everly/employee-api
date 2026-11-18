<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Collection;

final class InMemoryEmployeeRepository implements EmployeeRepository
{
    private int $autoIncrement = 1;

    /** @var Collection<int, Employee> */
    private Collection $collection;

    public function __construct()
    {
        $this->collection = new Collection;

        // Seed data since the in memory collection resets on every request
        $this->create('John', 'Smith', 'john.smith@example.com');
        $this->create('Jane', 'Doe', 'jane.doe@example.com');
    }

    public function all(): array
    {
        return $this->collection->values()->all();
    }

    public function find(int $id): ?Employee
    {
        return $this->collection->get($id);
    }

    public function findByEmail(string $email): ?Employee
    {
        return $this->collection->first(
            fn (Employee $employee) => strcasecmp($employee->email, $email) === 0
        );
    }

    public function create(string $firstName, string $lastName, string $email): Employee
    {
        $employee = new Employee(
            $this->autoIncrement++,
            $firstName,
            $lastName,
            $email
        );

        $this->collection->put($employee->id, $employee);

        return $employee;
    }

    public function delete(int $id): bool
    {
        if (! $this->collection->has($id)) {
            return false;
        }
        $this->collection->forget($id);

        return true;
    }
}
