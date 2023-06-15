<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->char('type_client', 2)->nullable();
            $table->string('social_razon')->nullable();
            $table->string('document')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable()->default(13);
            $table->unsignedBigInteger('municipio_id')->nullable()->default(1303);

            $table->unsignedBigInteger('service_request_id')->nullable();
            $table->foreign('service_request_id')->references('id')->on('service_requests');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('parroquia_id')->nullable();
            $table->foreign('parroquia_id')->references('id')->on('parroquias');

            $table->bigInteger('sector_id')->nullable()->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->bigInteger('nap_id')->nullable()->unsigned();
            $table->foreign('nap_id')->references('id')->on('naps');

            $table->string('gps')->nullable();

            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->float('balance', 10, 2)->nullable();
            $table->date('start_contract')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
