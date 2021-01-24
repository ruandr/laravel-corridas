<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvaCorredor extends Model
{
    use SoftDeletes;

    protected $table = 'provas_corredores';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_corredor',
        'id_prova'
    ];
}
