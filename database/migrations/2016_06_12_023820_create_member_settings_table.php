<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('member_settings'))
        {
            Schema::create('member_settings', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('setting_id')->unsigned(); //FK
                $table->integer('owner_id')->unsigned(); //FK but is generic
                $table->string('owner');
                $table->string('value');
                $table->timestamps();

                $table->foreign('setting_id')->references('id')->on('settings');
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
        Schema::dropIfExists('member_settings');
    }
}
