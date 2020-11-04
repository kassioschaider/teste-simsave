<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'company'], function ($router) {

	$router->get('','CompanyController@list');
	$router->post('','CompanyController@create');
	$router->get('{id}','CompanyController@get');
    $router->put('{id}','CompanyController@edit');
    $router->delete('{id}','CompanyController@delete');

    $router->get('{companyId}/employees', 'EmployeeController@listByCompany');

});

Route::group(['prefix' => 'employee'], function ($router) {

    $router->get('','EmployeeController@list');
    $router->post('','EmployeeController@create');
    $router->get('{id}','EmployeeController@get');
    $router->put('{id}','EmployeeController@edit');
    $router->delete('{id}','EmployeeController@delete');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
