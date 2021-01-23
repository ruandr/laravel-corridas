<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvasResultadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provas_resultado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_prova_corretor');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_prova_corretor')
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
        Schema::dropIfExists('provas_resultado');
    }
}
