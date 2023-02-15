<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collector_id');
            $table->unsignedBigInteger('client_id');
            $table->integer('credit_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('capital_amount');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('first_payment');
            $table->string('method_payment');
            $table->integer('frequency_payment');
            $table->timestamps();
            // relations
            $table->foreign('collector_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('loans');
    }
}
