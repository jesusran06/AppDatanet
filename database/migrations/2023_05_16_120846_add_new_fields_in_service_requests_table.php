<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->boolean('router')->nullable();
            $table->string('router_model')->nullable();
            $table->string('router_serial')->nullable();
            $table->boolean('cable')->nullable();
            $table->double('mount_cable', 6, 2)->nullable();
            $table->boolean('prorateo')->nullable();
            $table->double('mount_prorateo', 6, 2)->nullable();
            
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
            $table->dropColumn('router');
            $table->dropColumn('router_model');
            $table->dropColumn('router_serial');
            $table->dropColumn('cable');
            $table->dropColumn('mount_cable');
            $table->dropColumn('prorateo');
            $table->dropColumn('mount_prorateo');
        });
    }
}
