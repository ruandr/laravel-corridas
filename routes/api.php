<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api.request')->group(function () {
    Route::post('corredor', 'CorredoresController@create');
    Route::post('prova', 'ProvasController@create');
    Route::post('provaCorredor', 'ProvasCorredoresController@create');
    Route::post('resultado', 'ProvasResultadosController@create');
    Route::get('resultado/classificacaoPorIdade/{faixaDeIdade?}', 'ProvasResultadosController@listClassificationByAge');
    Route::get('resultado', 'ProvasResultadosController@listGeneralClassification');
});

// Route::prefix('v1')->group(['middleware' => ['api.request']], function () {

// });
