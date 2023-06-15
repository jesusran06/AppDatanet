<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubsectorIdServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('subsector_id')->after('sector_id')->unsigned()->nullable();
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
        Schema::table('service_requests', function (Blueprint $table) {
            //$table->dropForeign('subsector_id');
            //$table->dropIfExists('subsector_id');
            //$table->dropColumn('subsector_id');
        });
    }
}
