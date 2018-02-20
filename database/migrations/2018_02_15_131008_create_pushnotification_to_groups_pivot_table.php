<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushnotificationToGroupsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'push_notification_push_notification_group',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('push_notification_id');
                $table->integer('push_notification_group_id');
                $table->timestamps();

                $table->foreign('push_notification_id')
                    ->references('id')->on('pushnotifications')
                    ->onDelete('cascade');
                $table->foreign('push_notification_group_id')
                    ->references('id')->on('push_notification_groups')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pushnotification_to_groups');
    }
}
