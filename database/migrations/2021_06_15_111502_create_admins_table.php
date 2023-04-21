<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('name_kana', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('image')->nullable();
            $table->string('password', 200);
            $table->date('birthday')->nullable();
            $table->boolean('gender')->default(0)->comment('1 : man, 2 : woman')->nullable();
            $table->dateTime('first_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
