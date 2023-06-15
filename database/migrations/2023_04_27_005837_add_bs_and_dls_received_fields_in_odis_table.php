<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBsAndDlsReceivedFieldsInOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->float('total_dls_received',10, 2)->after('serial_point')->nullable();
            $table->float('total_bs_received',10, 2)->after('total_dls_received')->nullable();
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
            $table->dropColumn('total_dls_received');
            $table->dropColumn('total_bs_received');
        });
    }
}
