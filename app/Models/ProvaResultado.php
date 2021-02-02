<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\hasOne;
use App\Models\Corredor;
use App\Models\Prova;
use App\Models\ProvaCorredor;

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

    public function provaCorredor(): HasOne
    {
        return $this->hasOne(ProvaCorredor::class, 'id', 'id_prova_corredor');
    }
}
