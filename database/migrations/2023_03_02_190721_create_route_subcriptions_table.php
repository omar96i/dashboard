<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteSubcriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_subcriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('created_by');
            $table->integer('days');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('price');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('route_id')
            ->references('id')
            ->on('routes')
            ->onDelete('cascade');

            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_subcriptions');
        Schema::table('routes', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }
}
