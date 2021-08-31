<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->foreignId('critere_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
