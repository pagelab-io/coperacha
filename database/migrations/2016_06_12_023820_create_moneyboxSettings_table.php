<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyboxSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('moneyboxSettings'))
        {
            Schema::create('moneyboxSettings', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('setting_id')->unsigned(); //FK
                $table->integer('moneybox_id')->unsigned(); //FK
                $table->string('value');
                $table->timestamps();

                $table->foreign('setting_id')->references('id')->on('settings');
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
        Schema::dropIfExists('moneyboxSettings');
    }
}
