<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends BasicController
{
    public function __construct()
    {
        $this->class = Employee::class;
    }

    public function listByCompany(Request $request)
    {
        $employees = Employee::query()
            ->where('company_id', $request->companyId)->paginate($request->per_page);

        return $employees;
    }
}
