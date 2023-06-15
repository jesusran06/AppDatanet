<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayFieldsInOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->float('mount_cash_dl', 10, 2)->after('instalator_id')->nullable();
            $table->string('serials_cash_dl')->after('mount_cash_dl')->nullable();

           
            $table->float('mount_cash_bs', 10, 2)->after('serials_cash_dl')->nullable();
            $table->string('serials_cash_bs')->after('mount_cash_bs')->nullable();

           
            $table->float('mount_bank_transfer', 10, 2)->after('serials_cash_bs')->nullable();
            $table->string('serial_bank_transfer')->after('mount_bank_transfer')->nullable();

            $table->float('mount_zelle', 10, 2)->after('serial_bank_transfer')->nullable();
            $table->string('serial_zelle')->after('mount_zelle')->nullable();

            $table->float('mount_movil_paid', 10, 2)->after('serial_zelle')->nullable();
            $table->string('serial_movil_paid')->after('mount_movil_paid')->nullable();

            $table->float('mount_point', 10, 2)->after('serial_movil_paid')->nullable();
            $table->string('serial_point')->after('mount_point')->nullable();
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
            $table->dropColumn('mount_cash_dl');
            $table->dropColumn('serials_cash_dl');
            $table->dropColumn('mount_cash_bs');
            $table->dropColumn('serials_cash_bs');
            $table->dropColumn('mount_bank_transfer');
            $table->dropColumn('serial_bank_transfer');
            $table->dropColumn('mount_zelle');
            $table->dropColumn('serial_zelle');
            $table->dropColumn('mount_movil_paid');
            $table->dropColumn('serial_movil_paid');
            $table->dropColumn('mount_point');
            $table->dropColumn('serial_point');
        });
    }
}
