<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('moneyboxes'))
        {
            Schema::create('moneyboxes', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->integer('owner_id')->unsigned();
                $table->string('name', 128);
                $table->decimal('goal_amount',10,2);
                $table->decimal('collected_amount',10,2);
                $table->date('end_date');
                $table->text('description');
                $table->integer('active');
                $table->string('url',128);
                $table->timestamps();

                $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('moneyboxes');
    }
}
