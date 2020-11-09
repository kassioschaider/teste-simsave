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
            ]);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/company/6');
        $response->assertStatus(204);
    }
}
