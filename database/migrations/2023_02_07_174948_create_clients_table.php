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
            $table->unsignedBigInteger('created_by_user_id');
            $table->unsignedBigInteger('route_id');
            $table->date('binding_date');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('billing_address');
            $table->string('landline');
            $table->string('phone');
            $table->string('neighborhood');
            $table->string('description_business');
            $table->string('address_business');
            $table->string('phone_business');
            $table->string('email');
            $table->string('order');
            $table->string('status');
            $table->timestamps();

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
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
        Schema::dropIfExists('clients');
    }
}
