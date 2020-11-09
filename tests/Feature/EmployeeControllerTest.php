<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeControllerTest extends TestCase
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
            'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG",
        ]);
    }

    public function testGet()
    {
        $response = $this->get('/api/employee');
        $response->assertStatus(200);
    }

    public function testPost()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 1",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 11,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => "Funcinário 1",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 11,
                'id' => 4,
                'links' => [
                    'self' => "/api/employee/4",
                    'company' => "/api/company/11",
                ],
            ]);
    }

    public function testPut()
    {
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 2",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 12,
        ]);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/api/employee/5', [
            'name' => "Funcinário Editado",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 12,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => "Funcinário Editado",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 12,
                'id' => 5,
            ]);
    }

    public function testGetOne()
    {
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 3",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 13,
        ]);

        $response = $this->get('/api/employee/6');
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => "Funcinário 3",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 13,
                'id' => 6,
            ]);
    }

    public function testDelete()
    {
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/employee', [
            'name' => "Funcinário 4",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 14,
        ]);

        $response = $this->delete('/api/employee/7');
        $response->assertStatus(204);
        $this->get('/api/employee/7')->assertStatus(204);
    }

    public function testNoContentOrResource()
    {
        $this->get('/api/employee/999999999')
            ->assertStatus(204);

        $this->put('/api/employee/999999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => "Recurso inexistente"
            ]);

        $this->delete('/api/employee/999999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => "Recurso inexistente"
            ]);
    }
}
