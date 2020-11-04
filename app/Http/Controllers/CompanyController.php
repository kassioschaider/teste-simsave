<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{

    public function listCompanies()
    {
    	return Company::get();
    }

    public function getCompany(int $id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return response()->json('', 204);
        }
    	return response()->json($company);
    }

    public function createCompany(Request $request)
    {
    	return response()->json(Company::create($request->all()), 201);
    }

    public function editCompany(Request $request)
    {
        $company = Company::find($request->id);
        if (is_null($company)) {
            return response()->json(['error' => 'Recurso não encontrado'], 404);
        }
    	$company->update($request->all());

    	return $company;
    }

    public function deleteCompany(int $id)
    {
        if (Company::destroy($id) === 0) {
            return response()->json(['error' => 'Recurso não encontrado'], 404);
        }

        return response()->json('', 204);
    }

}
