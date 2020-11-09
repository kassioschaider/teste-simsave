<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/company', [
            'name' => 'Empresa 1',
            'cnpj' => '123.456.789.1000111',
            'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG"
        ]);
    }

    public function testGet()
    {
        $response = $this->get('/api/company');
        $response->assertStatus(200);
    }

    public function testPost()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/company', [
            'name' => 'Empresa 3',
            'cnpj' => '123.456.789.1000111',
            'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG"
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => 'Empresa 3',
                'cnpj' => '123.456.789.1000111',
                'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG",
                'id' => 3,
                'links' => [
                    'self' => "/api/company/3",
                    'employees' => "/api/company/3/employees",
                ],
            ]);
    }

    public function testPut()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/api/company/4', [
            'name' => 'Empresa Editada',
            'cnpj' => '123.456.789.111111',
            'address' => 'RUA EXEMPLO, XXX, EDITADO',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Empresa Editada',
                'cnpj' => '123.456.789.111111',
                'address' => 'RUA EXEMPLO, XXX, EDITADO',
                'id' => 4,
                'links' => [
                    'self' => "/api/company/4",
                    'employees' => "/api/company/4/employees",
                ],
            ]);
    }

    public function testGetOne()
    {
        $response = $this->get('/api/company/5');
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Empresa 1',
                'cnpj' => '123.456.789.1000111',
                'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG",
                'id' => 5,
                'links' => [
                    'self' => "/api/company/5",
                    'employees' => "/api/company/5/employees",
                ],
            ]);
    }

    public function testDeleteRestrito()
    {
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 1",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 6,
        ]);

        $response = $this->delete('/api/company/6');
        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => "Não é possível excluir essa empresa, pois ela tem funcionário(s)"
            ]);

    }

    public function testDelete()
    {
        $response = $this->delete('/api/company/7');
        $response->assertStatus(204);
        $this->get('/api/company/7')->assertStatus(204);
    }

    public function testNoContentOrResource()
    {
        $this->get('/api/company/999999999')
            ->assertStatus(204);

        $this->put('/api/company/999999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => "Recurso inexistente"
            ]);

        $this->delete('/api/company/999999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => "Recurso inexistente"
            ]);
    }

    public function testGetEmployees()
    {
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 1",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 9,
        ]);

        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 2",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 9,
        ]);

        $response = $this->get('/api/company/9/employees');

        $response
            ->assertStatus(200)
            ->assertJson([
                'current_page' => 1,
                'data' => [
                    0 => [
                        'id' => 2,
                        'name' => "Funcinário 1",
                        'role' => "Estagiário",
                        'email' => "employee@simsave.com.br",
                        'phone_number' => "3723-9909",
                        'admission_date' => "2018-05-31",
                        'company_id' => 9,
                        'deleted_at' => null,
                        'links' => [
                            'self' => "/api/employee/2",
                            'company' => "/api/company/9",
                        ],
                    ],
                    1 => [
                        'id' => 3,
                        'name' => "Funcinário 2",
                        'role' => "Estagiário",
                        'email' => "employee@simsave.com.br",
                        'phone_number' => "3723-9909",
                        'admission_date' => "2018-05-31",
                        'company_id' => 9,
                        'deleted_at' => null,
                        'links' => [
                            'self' => "/api/employee/3",
                            'company' => "/api/company/9",
                        ],
                    ],
                ],
                'first_page_url' => "http://localhost/api/company/9/employees?page=1",
                'from' => 1,
                'last_page' => 1,
                'last_page_url' => "http://localhost/api/company/9/employees?page=1",
                'next_page_url' => null,
                'path' => "http://localhost/api/company/9/employees",
                'per_page' => 15,
                'prev_page_url' => null,
                'to' => 2,
                'total' => 2,
            ]);
    }
}
