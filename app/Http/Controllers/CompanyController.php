<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;

class CompanyController extends BasicController
{
    public function __construct()
    {
        $this->class = Company::class;
    }

    public function delete(int $id)
    {
        if (Employee::query()->where('company_id', $id)->count()) {
            return response()->json([
                'error' => 'Não é possível excluir essa empresa, pois ela tem funcionário(s)'
            ], 404);
        }

        if ($this->class::destroy($id) === 0) {
            return response()->json(['error' => 'Recurso inexistente'], 404);
        }

        return response()->json('', 204);
    }
}
