<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->char('type_client')->after('id');
            $table->string('social_razon')->after('type_client');
            $table->string('document')->after('social_razon');
            $table->string('names')->after('document');
            $table->string('last_names')->after('names');
            $table->string('document2')->after('last_names');
            $table->string('address')->after('document2');
            $table->unsignedBigInteger('parroquia_id')->after('address');
            $table->unsignedBigInteger('sector_id')->after('parroquia_id')->unsigned();
            $table->string('celphone')->after('sector_id');
            $table->string('whatsapp')->after('celphone');
            $table->string('email')->after('whatsapp');
            $table->bigInteger('nap_id')->after('email')->unsigned();
            $table->float('distance')->after('nap_id');
            $table->string('gps')->after('distance');
            $table->bigInteger('instalation_id')->after('plan_id')->unsigned();
            $table->json('questionnaire')->after('instalation_id');
            $table->string('observations')->after('questionnaire');

            $table->unsignedBigInteger('client_id')->nullable()->change();
            $table->foreign('parroquia_id')->references('id')->on('parroquias');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('instalation_id')->references('id')->on('instalations');
            $table->foreign('nap_id')->references('id')->on('naps');
            

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
