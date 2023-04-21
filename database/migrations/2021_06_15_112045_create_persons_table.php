<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('family_id');
            $table->foreign('family_id')->references('id')->on('families');
            $table->string('name', 100);
            $table->integer('age');
            $table->boolean('gender')->comment('1 : man, 2 : woman');
            $table->boolean('option')->nullable()->default(0)->comment('load configs');
            $table->string('note')->nullable();
            $table->boolean('is_owner')->default(1)->comment('0 : owner, 1 : non-owner');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
