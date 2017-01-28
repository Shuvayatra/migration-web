<?php

use App\Nrna\Models\Screen;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'screens',
            function ($table) {
                $table->text('slug')->unique()->nullable();
            }
        );

        $screens = Screen::all();
        foreach ($screens as $screen) {
            $screen->slug = str_slug($screen->name);
            $screen->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'screens',
            function ($table) {
                $table->dropColumn('slug');
            }
        );

    }
}
