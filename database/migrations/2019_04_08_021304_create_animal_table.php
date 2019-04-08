<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->enum('porte', ['pequeno', 'medio', 'grande']);
            $table->integer('raca_id', false, true);
            $table->integer('proprietario_id', false, true);
            $table->foreign('raca_id')
                  ->references('id')->on('raca');
            $table->foreign('proprietario_id')
                ->references('id')->on('proprietario');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('animal');
    }
}
