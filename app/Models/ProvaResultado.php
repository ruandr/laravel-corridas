<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvaResultado extends Model
{
    use SoftDeletes;

    protected $table = 'provas_resultados';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_prova_corredor',
        'inicio',
        'fim'
    ];
}
