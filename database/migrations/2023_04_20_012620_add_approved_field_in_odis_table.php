<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedFieldInOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odis', function (Blueprint $table) {
            $table->boolean('approved')->default(0)->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->date('approved_date')->nullable();
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
            $table->dropIfExists('approved');
            $table->dropConstrainedForeignId('approved_by');
            //$table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
    }
}
