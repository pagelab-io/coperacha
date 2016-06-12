<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyboxCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('moneyboxCategories'))
        {
            Schema::create('moneyboxCategories', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name', 128);
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
        Schema::dropIfExist('moneyboxCategories');
    }
}
