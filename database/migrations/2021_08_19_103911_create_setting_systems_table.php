<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system_name_ja');
            $table->string('system_name_en');
            $table->string('type_name_ja');
            $table->string('type_name_en');
            $table->string('footer');
            $table->integer('map_scale');
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
        Schema::dropIfExists('setting_systems');
    }
}
