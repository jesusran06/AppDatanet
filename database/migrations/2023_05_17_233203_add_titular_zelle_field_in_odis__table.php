<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitularZelleFieldInOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->string('titular_zelle')->nullable()->after('serial_zelle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->dropColumn('titular_zelle');
        });
    }
}
