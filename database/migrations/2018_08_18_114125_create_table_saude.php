<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSaude extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saude', function (Blueprint $table) {           
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('uuid',64)->nullable();
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('datum');
            $table->time('uhrzeit');
            $table->decimal('gewicht',8,3);
            $table->integer('diastole');
            $table->integer('systole');
            $table->integer('puls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saude');
    }
}
