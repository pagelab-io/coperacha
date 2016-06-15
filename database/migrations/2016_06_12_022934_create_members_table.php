<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('members'))
        {
            Schema::create('members', function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments('id');
                $table->integer('person_id')->unsigned(); //FK
                $table->integer('moneybox_id')->unsigned(); //FK
                $table->timestamps();

                $table->foreign('person_id')->references('id')->on('persons');
                $table->foreign('moneybox_id')->references('id')->on('moneyboxes');

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
        Schema::dropIfExists('members');
    }
}
