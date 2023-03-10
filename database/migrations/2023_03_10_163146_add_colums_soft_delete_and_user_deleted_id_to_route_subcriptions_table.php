<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsSoftDeleteAndUserDeletedIdToRouteSubcriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('route_subcriptions', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->foreign('user_deleted_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('route_subcriptions', function (Blueprint $table) {
            $table->dropForeign(['user_deleted_id']);
            $table->dropColumn(['user_deleted_id']);
            $table->dropSoftDeletes();
        });
    }
}
