<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MovimentaTest extends TestCase
{
    public function test_depositar_conta_5030()
    {
        $data = [ 'conta' => 5030, 'valor' => 999.99 ];
        $this->json('POST', 'api/depositar', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data" => [
                  "depositar" => [
                    "conta", "saldo",
                  ],
                ],
            ]);
    }

    public function test_sacar_conta_5030()
    {
        $data = [ 'conta' => 5030, 'valor' => 99.09 ];
        $this->json('POST', 'api/sacar', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data" => [
                  "sacar" => [
                    "conta", "saldo",
                  ],
                ],
            ]);
    }
}

?>

