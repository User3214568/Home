<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('note')->nullable();
            $table->integer('etudiant_cin')->unsigned();
            $table->foreign('etudiant_cin')->references('cin')->on('etudiants')->onDelete('cascade');
            $table->unsignedBigInteger('devoir_id');
            $table->foreign('devoir_id')->references('id')->on('devoirs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
