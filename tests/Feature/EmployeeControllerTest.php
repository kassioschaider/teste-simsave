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
            'company_id' => 8,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => "Funcinário 1",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 8,
                'id' => 1,
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
            'company_id' => 9,
        ]);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/api/employee/2', [
            'name' => "Funcinário Editado",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 9,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => "Funcinário Editado",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 9,
                'id' => 2,
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
            'company_id' => 10,
        ]);

        $response = $this->get('/api/employee/3');
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => "Funcinário 3",
                'role' => "Estagiário",
                'email' => "employee@simsave.com.br",
                'phone_number' => "3723-9909",
                'admission_date' => "2018-05-31",
                'company_id' => 10,
                'id' => 3,
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
            'company_id' => 11,
        ]);

        $response = $this->delete('/api/employee/4');
        $response->assertStatus(204);
    }
}
