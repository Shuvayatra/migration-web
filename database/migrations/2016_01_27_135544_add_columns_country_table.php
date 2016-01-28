<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country', function ($table) {
            $table->text('contact')->nullable();
            $table->text('do_and_dont')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country', function($table)
        {
            $table->dropColumn('contact');
            $table->dropColumn('do_and_dont');
        });

    }
}
