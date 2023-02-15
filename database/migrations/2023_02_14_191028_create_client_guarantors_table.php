<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_guarantors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('full_name');
            $table->string('country_code');
            $table->string('phone');
            $table->string('landline');
            $table->string('address');
            $table->string('address_business');
            $table->string('phone_business');
            $table->timestamps();
            // relations
            $table->foreign('client_id')
              ->references('id')
              ->on('clients')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_guarantors');
    }
}
