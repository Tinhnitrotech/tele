<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('tel', 20);
            $table->string('zip_code',10);
            $table->integer('prefecture_id');
            $table->string('address');
            $table->string('zip_code_default',10);
            $table->integer('prefecture_id_default');
            $table->string('address_default');
            $table->integer('total_place');
            $table->boolean('active_flg')->default(0)->comment('0 : non-active / 1 : active');
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
        Schema::dropIfExists('places');
    }
}
