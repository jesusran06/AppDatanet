<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServiceRequestNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('names')->nullable()->change();
            $table->string('social_razon')->nullable()->change();
            $table->date('birthdate')->nullable()->change();
            $table->string('last_names')->nullable()->change();
            $table->string('document')->nullable()->change();
            $table->string('document2')->nullable()->change();
            $table->string('whatsapp')->nullable()->change();
            $table->float('distance')->nullable()->change();
            $table->string('questionnaire')->nullable()->change();
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
