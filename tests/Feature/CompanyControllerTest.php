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
            'name' => 'Empresa 2',
            'cnpj' => '123.456.789.1000111',
            'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG"
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => 'Empresa 2',
                'cnpj' => '123.456.789.1000111',
                'address' => "Rua XXXXX, XXXX - XXXXXX - Belo Horizonte / MG"
            ]);
    }

    public function testPut()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/api/company/4', [
            'name' => 'Empresa 3',
            'cnpj' => '123.456.789.111111',
            'address' => 'RUA EXEMPLO, XXX, EDITADO',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Empresa 3',
                'cnpj' => '123.456.789.111111',
                'address' => 'RUA EXEMPLO, XXX, EDITADO',
            ]);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/company/5');
        $response->assertStatus(204);
    }
}
