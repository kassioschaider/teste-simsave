<?php

namespace App\Http\Controllers;

use App\Employee;

class EmployeeController extends BasicController
{
    public function __construct()
    {
        $this->class = Employee::class;
    }
}
