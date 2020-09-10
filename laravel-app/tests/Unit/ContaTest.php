<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ContaTest extends TestCase
{
    public function test_create_conta_recusa_sem_cliente()
    {
        $data = [];
        $this->json('PUT', 'api/conta', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "error",
                "message" => "Missing parameters", 
            ]);
    }

    public function test_create_conta_5030()
    {
        $data = [ 'cliente' => 130, 'id' => '5030' ];
        $this->json('PUT', 'api/conta', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    
    public function test_lista_contas()
    {
        $response = $this->get('/contas.json/130');
        $response->assertStatus(200);
    }
}

?>

