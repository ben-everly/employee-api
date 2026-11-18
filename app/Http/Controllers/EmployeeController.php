<?php

namespace App\Http\Controllers;

use App\Exceptions\EmployeeNotFoundException;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class EmployeeController extends Controller
{
    public function __construct(
        private readonly EmployeeRepository $employees
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return EmployeeResource::collection($this->employees->all());
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employees->create(
            $request->validated('firstName'),
            $request->validated('lastName'),
            $request->validated('email'),
        );

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $employee): EmployeeResource
    {
        $found = $this->employees->find($employee);

        if ($found === null) {
            throw new EmployeeNotFoundException($employee);
        }

        return new EmployeeResource($found);
    }

    public function destroy(int $employee): Response
    {
        if (! $this->employees->delete($employee)) {
            throw new EmployeeNotFoundException($employee);
        }

        return response()->noContent();
    }
}
