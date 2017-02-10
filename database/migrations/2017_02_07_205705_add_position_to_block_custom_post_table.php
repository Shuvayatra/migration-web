<?php

use App\Nrna\Models\Block;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToBlockCustomPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'block_custom_post',
            function (Blueprint $table) {
                $table->integer('position')->default(0);;
            }
        );
        $blocks = Block::get();
        foreach ($blocks as $block) {
            foreach ($block->custom_posts as $key => $post) {
                $block->custom_posts()->updateExistingPivot($post->id, ['position' => ++$key]);
            }

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
            'block_custom_post',
            function (Blueprint $table) {
                $table->dropColumn('position');
            }
        );
    }
}
