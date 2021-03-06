<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('persons'))
        {
            Schema::create('persons', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name', 128);
                $table->string('lastname', 128);
                $table->date('birthday');
                $table->enum('gender', ['H','M']);
                $table->string('phone', 15);
                $table->string('city', 128);
                $table->string('country', 128);
                $table->string('path', 256);
                $table->timestamps();
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
        Schema::dropIfExists('persons');
    }
}
