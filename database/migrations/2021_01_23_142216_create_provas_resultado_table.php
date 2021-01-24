<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvasResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provas_resultados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_prova_corredor');
            $table->dateTime('inicio');
            $table->dateTime('fim');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_prova_corredor')
                ->references('id')
                ->on('provas_corredores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provas_resultados');
    }
}
