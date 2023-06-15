<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document');
            $table->string('address');
            $table->unsignedInteger('state_id')->default(13);
            $table->unsignedInteger('municipio_id')->default(1303);
            $table->unsignedInteger('parroquia_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('subsector_id');
            $table->string('celphone');
            $table->string('whatsapp');
            $table->string('email');
            $table->timestamps();
            /*$table->foreign('state_id')->references('id')->on('states');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('parroquia_id')->references('id')->on('parroquias');*/
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
