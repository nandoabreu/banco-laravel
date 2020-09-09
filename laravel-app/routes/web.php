<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//Route::put('cliente', function () {
//    return response()->json([Input]);
//});


Route::get('clientes', function () {
    $list = \App\Cliente::all()->sortBy('nome');
    return view('clientes', ['list' => $list]);
});

Route::get('clientes.json', function () {
	$list = \App\Cliente::all();
    return response()->json([$list]);
});


Route::get('contas/{cliente}', function ($cliente) {
	$nome = \App\Cliente::where('id', $cliente)->first()->nome;
	$list = \App\Conta::all()->where('cliente', $cliente);
    return view('contas', ['nome' => $nome, 'list' => $list]);
});

Route::get('contas.json/{cliente}', function ($cliente) {
	$list = \App\Conta::all()->where('cliente', $cliente);
    return response()->json([$list]);
});


Route::get('conta/{id}', function ($id) {
	$data = \App\Conta::where('id', $id)->first();
    return view('conta', ['data' => $data]);
});

Route::get('conta.json/{id}', function ($id) {
	$data = \App\Conta::where('id', $id)->first();
    return response()->json([$data]);
});

