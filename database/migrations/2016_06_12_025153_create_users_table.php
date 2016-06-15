<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users'))
        {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->string('email', 128)->unique();
                $table->string('password', 128);
                $table->string('username',128)->unique();
                $table->integer('first_access',false,true);
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
        Schema::dropIfExists('users');
    }
}
