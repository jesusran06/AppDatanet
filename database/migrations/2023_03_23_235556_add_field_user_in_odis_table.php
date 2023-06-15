<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUserInOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->unsignedBigInteger('instalator_id')->after('observations')->nullable();
            $table->foreign('instalator_id')->references('id')->on('users');
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
            $table->dropConstrainedForeignId('instalator_id');
        });
    }
}
