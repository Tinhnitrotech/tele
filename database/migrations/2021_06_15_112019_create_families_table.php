<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('family_code')->nullable();
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('places');
            $table->string('address');
            $table->string('zip_code', 10);
            $table->integer('prefecture_id');
            $table->string('tel',20);
            $table->dateTime('join_date');
            $table->dateTime('out_date')->nullable();
            $table->string('password', 200);
            $table->boolean('is_public')->default(0)->comment('0 : public, 1 : non-public');
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
        Schema::dropIfExists('families');
    }
}
