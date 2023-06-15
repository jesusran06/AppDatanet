<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NapParroquia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('naps', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->integer('nro')->after('name');
            $table->string('gps')->after('nro');
            $table->unsignedBigInteger('subsector_id')->after('gps');
            $table->string('address')->after('subsector_id');
            $table->foreign('subsector_id')->references('id')->on('subsectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
