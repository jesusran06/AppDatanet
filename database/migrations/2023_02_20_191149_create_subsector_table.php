<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsectors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->bigInteger('sector_id')->unsigned();
            $table->foreign('sector_id')
                    ->references('id')
                    ->on('sectors')
                    ->onCascade('delete');
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
        Schema::dropIfExists('subsectors');
    }
}
