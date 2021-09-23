<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText("message");
        });
        Schema::create('notification_user',function(Blueprint $table){
            $table->id();
            $table->boolean('seen')->default(false);
            $table->string('user_cin');
            $table->foreign('user_cin')->references('cin')->on('users')->onDelete('cascade');
            $table->foreignId('notification_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');

        Schema::dropIfExists('notification_user');
    }
}
