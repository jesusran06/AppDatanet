<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('reel')->nullable();
            $table->bigInteger('reel_start_mts')->nullable();
            $table->bigInteger('reel_end_mts')->nullable();
            $table->float('total_distance', 10, 2)->nullable();
            $table->integer('nap_port')->nullable();
            $table->integer('nap_potency')->nullable();
            $table->string('fast_conector')->nullable(); //conector rapido
            $table->string('pgtail')->nullable();
            $table->integer('strapping')->nullable(); //flejes
            $table->integer('hoops')->nullable(); //aros
            $table->integer('heat_shrinkable')->nullable(); //termoencogible
            $table->integer('rosettes')->nullable(); //rosetas
            $table->integer('staples')->nullable(); //grapas
            $table->float('client_potency', 10, 2)->nullable();
            $table->float('return_potency', 10, 2)->nullable();
            $table->string('onu_serial')->nullable();
            $table->date('instalation_date')->nullable();
            $table->text('observations');
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
        Schema::dropIfExists('odis');
    }
}
