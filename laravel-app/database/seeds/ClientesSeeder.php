<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::insert([
		[ 'id' => 101, 'nome' => 'Fernando Abreu', ],
		[ 'id' => 102, 'nome' => 'Ricardo Alves', ],
		[ 'id' => 103, 'nome' => 'Bruno Lima', ],
		[ 'id' => 104, 'nome' => 'Andre Brasiliano', ],
		[ 'id' => 105, 'nome' => 'Michèle Roy-Coste', ],
	]);
    }
}

