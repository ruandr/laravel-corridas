<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api.request')->group(function () {
    Route::post('corredor', 'CorredoresController@create');
    Route::get('corredor/{cpf}', 'CorredoresController@getByCpf');
    Route::get('corredores', 'CorredoresController@all');

    Route::post('prova', 'ProvasController@create');
    Route::get('provas', 'ProvasController@all');
    Route::get('provas/{paramType}/{param}', 'ProvasController@getByParam');

    Route::post('provaCorredor', 'ProvasCorredoresController@create');
    Route::get('provasCorredores', 'ProvasCorredoresController@all');
    Route::get('provaCorredor/{idProva}/{idCorredor}', 'ProvasCorredoresController@find');

    Route::post('resultado', 'ProvasResultadosController@create');
    Route::get('resultado/classificacaoPorIdade/{faixaDeIdade?}', 'ProvasResultadosController@listClassificationByAge');
    Route::get('resultado', 'ProvasResultadosController@listGeneralClassification');
});

// Route::prefix('v1')->group(['middleware' => ['api.request']], function () {

// });
