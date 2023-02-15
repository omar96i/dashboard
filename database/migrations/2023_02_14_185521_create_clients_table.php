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
            $table->bigInteger('id_card');
            $table->string('full_name');
            $table->string('address_billing');
            $table->string('address');
            $table->string('landline');
            $table->string('country_code');
            $table->string('phone');
            $table->string('neighbothood');
            $table->string('description_business');
            $table->string('address_business');
            $table->string('phone_business');
            $table->string('email');
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
        Schema::dropIfExists('clients');
    }
}
