<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiant_module', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('etudiant_cin');
            $table->unsignedBigInteger('module_id');
            $table->foreign('etudiant_cin')->references('etudiants')->on('cin')->onDelete('cascade');
            $table->foreign('module_id')->references('modules')->on('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiant_module');
    }
}
