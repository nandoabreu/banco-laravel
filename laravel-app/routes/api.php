<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('sacar', function (Request $request) {
    if (!isset($request->all()['conta']) or !isset($request->all()['valor'])) {
		return Response::json(['status' => 'error', 'message' => 'Missing parameters']);
	}
    else {
		try {
			if (!preg_match('/^[0-9]*$/', $request->all()['conta'])) throw new Exception('Invalid value in conta');
			if (!preg_match('/^\-?[0-9]*(\.[0-9]{1,2})?$/', $request->all()['valor'])) throw new Exception('Invalid value in valor');

			$conta = intval($request->all()['conta']);
			$valor = abs(floatval($request->all()['valor']));
			if ($conta == 0 or $valor < 0.01) throw new Exception('Invalid values');

			$res = DB::selectOne("SELECT ativa, saldo FROM contas WHERE id = $conta");
			if (!$res) throw new Exception('Conta invalida');
			else if ($res->ativa != 1) throw new Exception('Conta inativa');
			else if ($res->saldo < $valor) throw new Exception('Saldo insuficiente');
		}
		catch(Exception $e) {
			return Response::json(['status' => 'error', 'message' => $e->getMessage() ]);
		}

		DB::update("UPDATE contas SET saldo = CAST((saldo - $valor) as numeric) WHERE id = $conta");
		$res = DB::selectOne("SELECT ativa, saldo FROM contas WHERE id = $conta");
		$data = [ 'sacar' => [ 'conta' => $conta, 'saldo' => $res->saldo ] ];
		return Response::json([ 'status' => 'Success', 'data' => $data ]);
    }
});

Route::post('depositar', function (Request $request) {
    if (!isset($request->all()['conta']) or !isset($request->all()['valor'])) {
		return Response::json(['status' => 'error', 'message' => 'Missing parameters']);
	}
    else {
		try {
			if (!preg_match('/^[0-9]*$/', $request->all()['conta'])) throw new Exception('Invalid value in conta');
			if (!preg_match('/^\-?[0-9]*(\.[0-9]{1,2})?$/', $request->all()['valor'])) throw new Exception('Invalid value in valor');

			$conta = intval($request->all()['conta']);
			$valor = abs(floatval($request->all()['valor']));
			if ($conta == 0 or $valor < 0.01) throw new Exception('Invalid values');

			$res = DB::selectOne("SELECT ativa FROM contas WHERE id = $conta");
			if (!$res) throw new Exception('Conta invalida');
			else if ($res->ativa != 1) throw new Exception('Conta inativa');
		}
		catch(Exception $e) {
			return Response::json(['status' => 'error', 'message' => $e->getMessage() ]);
		}

		DB::update("UPDATE contas SET saldo = CAST((saldo + $valor) as numeric) WHERE id = $conta");
		$res = DB::selectOne("SELECT saldo FROM contas WHERE id = $conta");
		$data = [ 'depositar' => [ 'conta' => $conta, 'saldo' => $res->saldo ] ];
		return Response::json([ 'status' => 'Success', 'data' => $data ]);
    }
});

Route::put('conta', function (Request $request) {
    if (!isset($request->all()['cliente'])) {
		return Response::json(['status' => 'error', 'message' => 'Missing parameters']);
    }
    else {
		$cliente = intval($request->all()['cliente']);
		$res = DB::selectOne("SELECT COUNT(*) FROM clientes WHERE id = ?", [intval($cliente)]);
		if ($res->count != 1) return Response::json(['status' => 'error', 'message' => 'Invalid record']);

		$keys = 'cliente';
		$vals = $cliente;

		if (isset($request->all()['id'])) {
			$id = preg_replace('/[^0-9]/', '', $request->all()['id']);
			if (strlen($id) > 0) { $keys .= ',id'; $vals .= ','.intval($id); }
		}

		if (isset($request->all()['tipo'])) {
			$tipo = preg_replace('/[^A-Za-z]/', '', $request->all()['tipo']);
			if (strlen($tipo) > 0) { $keys .= ',tipo'; $vals .= ",'".$tipo."'"; }
		}

		if (isset($request->all()['saldo'])) {
			$saldo = preg_replace('/[^0-9\-\.]/', '', $request->all()['saldo']);
			if (strlen($saldo) > 0) { $keys .= ',saldo'; $vals .= ','.floatval($saldo); }
		}

		DB::beginTransaction();
		try {
			$res = DB::selectOne("INSERT INTO contas ($keys) VALUES ($vals) RETURNING id, cliente, tipo, ativa, saldo");
			DB::selectOne("SELECT setval('contas_id_seq', (SELECT MAX(id) FROM contas), true)");
			DB::commit();
		}
		catch(Exception $e) {
			DB::rollback();
			return Response::json(['status' => 'error', 'message' => 'Query error' ]);
			#return Response::json(['status' => 'error', 'message' => $e->getMessage() ]);
		}

		return Response::json(['status' => 'Success', 'data' => $res ]);
    }
});

Route::put('cliente', function (Request $request) {
    if (!isset($request->all()['nome'])) {
		return Response::json(['status' => 'error', 'message' => 'Missing parameters']);
	}
    else {
		$nome = preg_replace('/[^\s\p{L}]/u', '', $request->all()['nome']);
		if (strlen($nome) < 1) return Response::json(['status' => 'error', 'message' => 'Invalid characters in nome']);

		$keys = 'nome';
		$vals = "'$nome'";

		if (isset($request->all()['id'])) {
			$id = preg_replace('/[^0-9]/', '', $request->all()['id']);
			if (strlen($id) > 0) { $keys .= ',id'; $vals .= ','.intval($id); }
		}

		DB::beginTransaction();
		try {
			$res = DB::selectOne("INSERT INTO clientes ($keys) VALUES ($vals) RETURNING id, nome");
			DB::selectOne("SELECT setval('clientes_id_seq', (SELECT MAX(id) FROM clientes), true)");
			DB::commit();
		}
		catch(Exception $e) {
			DB::rollback();
			return Response::json(['status' => 'error', 'message' => 'Query error' ]);
			#return Response::json(['status' => 'error', 'message' => $e->getMessage() ]);
		}

		$data = [ 'status' => 'Success', 'data' => [ 'cliente' => $res ] ];

		return Response::json($data);
    }
});

