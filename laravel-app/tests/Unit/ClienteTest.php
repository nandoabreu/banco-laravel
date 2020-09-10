<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    public function test_create_cliente_recusa_sem_nome()
    {
        $data = [];
        $this->json('PUT', 'api/cliente', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "error",
                "message" => "Missing parameters", 
            ]);
    }

    public function test_create_cliente_Xpto_Zyb()
    {
        $data = [ 'nome' => 'Xpto Zyb', 'id' => '130' ];
        $this->json('PUT', 'api/cliente', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    
    public function test_lista_clientes()
    {
        $response = $this->get('/clientes');
        $response->assertStatus(200);
    }
}

?>

