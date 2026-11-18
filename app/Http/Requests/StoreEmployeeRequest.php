<?php

namespace App\Http\Requests;

use App\Repositories\EmployeeRepository;
use App\Rules\UniqueEmployeeEmail;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(EmployeeRepository $employees): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'email', 'max:255', new UniqueEmployeeEmail($employees)],
        ];
    }
}
