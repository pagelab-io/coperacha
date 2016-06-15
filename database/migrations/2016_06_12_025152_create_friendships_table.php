<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('friendships'))
        {
            Schema::create('friendships', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('person_id')->unsigned(); //FK
                $table->integer('friend_id');
                $table->timestamps();

                $table->foreign('person_id')->references('id')->on('persons');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('friendships');
    }
}
