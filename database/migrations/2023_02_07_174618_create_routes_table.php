<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asigned_to_user_id');
            $table->unsignedBigInteger('asigned_to_collector_id')->nullable();
            $table->unsignedBigInteger('created_by_user_id');
            $table->string('name');
            $table->string('expired');
            $table->string('status');
            $table->timestamps();
            $table->foreign('asigned_to_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('asigned_to_collector_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('routes');
    }
}
