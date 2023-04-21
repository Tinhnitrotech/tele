<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('family_id');
            $table->foreign('family_id')->references('id')->on('families');
            $table->unsignedInteger('prefecture_id');
            $table->unsignedInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places');
            $table->boolean('status')->comment('0 : checkin / 1 : checkout');
            $table->dateTime('access_datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('join_logs');
    }
}
