<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [ 'id', 'cliente', 'tipo', 'ativa', 'saldo' ];
}

