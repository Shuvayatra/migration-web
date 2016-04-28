<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPushNotificationResponseColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pushnotifications', function (Blueprint $table) {
            $table->dropColumn('response');
        });
        Schema::table('pushnotifications', function (Blueprint $table) {
            $table->text('response')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pushnotifications', function (Blueprint $table) {
            $table->dropColumn('response');
        });
        Schema::table('pushnotifications', function (Blueprint $table) {
            $table->json('response')->nullable();
        });
    }
}
