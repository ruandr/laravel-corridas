<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\hasOne;
use App\Models\Corredor;
use App\Models\Prova;

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

    public function corredor(): HasOne
    {
        return $this->hasOne(Corredor::class, 'id', 'id_corredor');
    }

    public function prova(): HasOne
    {
        return $this->hasOne(Prova::class, 'id', 'id_prova');
    }
}
