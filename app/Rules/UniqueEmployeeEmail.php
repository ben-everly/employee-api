<?php

namespace App\Rules;

use App\Repositories\EmployeeRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class UniqueEmployeeEmail implements ValidationRule
{
    public function __construct(
        private readonly EmployeeRepository $employees
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->employees->findByEmail($value) !== null) {
            $fail('The :attribute has already been taken.');
        }
    }
}
