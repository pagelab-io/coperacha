<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyboxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('moneyboxPayments'))
        {
            Schema::create('moneyboxPayments', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('person_id')->unsigned(); //FK
                $table->integer('moneybox_id')->unsigned(); //FK
                $table->decimal('amount',10,2);
                $table->enum('method', ['p','o','s']);
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
        Schema::dropIfExists('moneyboxPayments');
    }
}
