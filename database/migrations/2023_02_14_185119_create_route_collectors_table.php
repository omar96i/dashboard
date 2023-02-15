<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteCollectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_collectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collector_id');
            $table->unsignedBigInteger('route_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            // relations
            $table->foreign('collector_id')
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
        Schema::dropIfExists('route_collectors');
    }
}
