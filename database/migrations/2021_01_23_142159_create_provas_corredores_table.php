<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvasCorredoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provas_corredores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_corredor');
            $table->unsignedBigInteger('id_prova');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_corredor')
                ->references('id')
                ->on('corredores');
                
            $table->foreign('id_prova')
                ->references('id')
                ->on('provas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provas_corredores');
    }
}
