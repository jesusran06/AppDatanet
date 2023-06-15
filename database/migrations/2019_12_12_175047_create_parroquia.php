<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParroquia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parroquias', function (Blueprint $table) {
            $table->id();
            $table->string('parroquia', 100);
            $table->unsignedBigInteger('id_parroquia');
            $table->unsignedBigInteger('id_municipio');
            $table->timestamps();
            $table->foreign('id_municipio')->references('id')->on('municipios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parroquia');
    }
}
