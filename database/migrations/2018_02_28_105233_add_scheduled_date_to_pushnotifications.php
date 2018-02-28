<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScheduledDateToPushnotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pushnotifications', function (Blueprint $table) {
            $table->timestamp('scheduled_date')->nullable();
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
            $table->dropColumn('scheduled_date');
        });
    }
}
