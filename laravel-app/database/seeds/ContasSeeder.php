<?php

use Illuminate\Database\Seeder;
use App\Conta;

class ContasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conta::insert([
		[ 'id' => 5001, 'cliente' => 101, 'tipo' => 'Poupanca', 'ativa' => false, ],
		[ 'id' => 5002, 'cliente' => 101, 'tipo' => 'Corrente', 'ativa' => true, ],
		[ 'id' => 5003, 'cliente' => 102, 'tipo' => 'Corrente', 'ativa' => false, ],
		[ 'id' => 5004, 'cliente' => 102, 'tipo' => 'Poupanca', 'ativa' => true, ],
		[ 'id' => 5005, 'cliente' => 103, 'tipo' => 'Corrente', 'ativa' => true, ],
		[ 'id' => 5006, 'cliente' => 104, 'tipo' => 'Corrente', 'ativa' => true, ],
		[ 'id' => 5007, 'cliente' => 105, 'tipo' => 'Corrente', 'ativa' => true, ],
	]);
    }
}

