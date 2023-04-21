<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEnToPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->integer('prefecture_en_id')->nullable()->after('address');
            $table->string('address_en')->nullable()->after('prefecture_en_id');
            $table->integer('prefecture_default_en_id')->nullable()->after('address_default');
            $table->string('address_default_en')->nullable()->after('prefecture_default_en_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('prefecture_en_id');
            $table->dropColumn('address_en');
            $table->dropColumn('prefecture_default_en_id');
            $table->dropColumn('address_default_en');
        });
    }
}
