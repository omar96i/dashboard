<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('client_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            // relations
            $table->foreign('business_id')
            ->references('id')
            ->on('business')
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
        Schema::dropIfExists('business_clients');
    }
}
