<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteres',function(Blueprint $table){
            $table->id();
            $table->float('note_validation');
            $table->float('note_aj');
            $table->integer('number_aj');
            $table->integer('number_nv');
            $table->timestamps();
        });

        Schema::table('formations',function(Blueprint $table){
            $table->unsignedBigInteger('critere_id');
            $table->foreign('critere_id')->references('id')->on('criteres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('criteres');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
