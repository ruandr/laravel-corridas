<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prova extends Model
{
    use SoftDeletes;

    protected $table = 'provas';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'tipo_prova',
        'data',
    ];
}
