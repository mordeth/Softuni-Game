<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attacker');
            $table->integer('defender');
            $table->string("in_progress");
            $table->integer('winner');
            $table->timestamp('end_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer("attacker_archer");
            $table->integer("attacker_swordsman");
            $table->integer("attacker_knight");
            $table->integer("defender_archer");
            $table->integer("defender_swordsman");
            $table->integer("defender_knight");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('battles');
    }
}
