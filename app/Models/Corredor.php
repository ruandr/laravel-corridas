<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corredor extends Model
{
    use SoftDeletes;

    protected $table = 'corredores';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
    ];
}
