<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryInfoCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'categories',
            function ($table) {
                $table->json('country_info')->nullable();
                $table->boolean('status')->default('true');;
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
        Schema::table(
            'categories',
            function ($table) {
                $table->dropColumn('country_info');
                $table->dropColumn('status');
            }
        );

    }
}
