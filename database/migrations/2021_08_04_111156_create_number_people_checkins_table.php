<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberPeopleCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_people_checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->integer('total_person_checkin');
            $table->integer('pregnant');
            $table->integer('infants');
            $table->integer('disability');
            $table->integer('caregiver');
            $table->integer('medical_device_user');
            $table->integer('allergic');
            $table->integer('foreign');
            $table->integer('other');
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
        Schema::dropIfExists('number_people_checkins');
    }
}
