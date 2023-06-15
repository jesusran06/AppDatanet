<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInDlsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->float('brute_amount_dls', 10, 2)->after('total_amount')->nullable();
            $table->float('tax_amount_dls', 10, 2)->after('brute_amount_dls')->nullable();
            $table->float('total_amount_dls', 10, 2)->after('tax_amount_dls')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('brute_amount_dls');
            $table->dropColumn('tax_amount_dls');
            $table->dropColumn('total_amount_dls');
        });
    }
}
