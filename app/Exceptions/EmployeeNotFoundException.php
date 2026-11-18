<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class EmployeeNotFoundException extends NotFoundHttpException
{
    public function __construct(int $id)
    {
        parent::__construct("Employee {$id} not found.");
    }
}
