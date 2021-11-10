<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->float('montant');

            $table->unsignedInteger('formation_id');
            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('cascade');

            $table->date('date_payement');
            $table->unsignedBigInteger("teacher_id");
            $table->foreign("teacher_id")->references("id")->on("teachers")->onDelete("cascade");
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
        Schema::dropIfExists('paiements');
    }
}
