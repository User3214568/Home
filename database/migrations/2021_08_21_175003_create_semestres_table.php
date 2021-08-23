<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned();
            $table->timestamps();
            $table->foreignId('formation_id')->constrained();
        });
        Schema::create('module_semestre', function (Blueprint $table) {
            $table->unsignedBigInteger('semestre_id');
            $table->unsignedBigInteger('module_id');
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('module_semestre');
    }
}
