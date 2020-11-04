<?php

namespace App\Http\Controllers;

use App\Company;

class CompanyController extends BasicController
{
    public function __construct()
    {
        $this->class = Company::class;
    }
}
