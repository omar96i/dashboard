<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('time_zone');
            $table->string('path_icon');
            $table->string('description');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            //relations users table
            $table->foreign('business_id')
            ->references('id')
            ->on('business')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_business_id_foreign');
        });
        Schema::dropIfExists('business');
    }
}
