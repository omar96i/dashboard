<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('client_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('priority');
            $table->timestamps();
             // relations
            $table->foreign('route_id')
             ->references('id')
             ->on('routes')
             ->onDelete('cascade');
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
        Schema::dropIfExists('routes_clients');
    }
}
