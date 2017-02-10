<?php

namespace App\Http\Controllers\Block;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\BlockRequest;
use App\Nrna\Models\Block;
use App\Nrna\Services\BlockService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class PostController extends Controller
{
    /**
     * @var BlockService
     */
    private $blockService;

    /**
     * BlockController constructor.
     *
     * @param BlockService $blockService
     */
    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * store custom posts
     *
     * @param Request $request
     * @param         $blockId
     *
     * @return array
     */
    public function store(Request $request, $blockId)
    {
        $block = $this->blockService->find($blockId);
        $block->custom_posts()->attach($request->get('post_id'));
        $block             = $this->blockService->find($blockId);
        $custom_posts      = $block->custom_posts;
        $custom_post_table = view('block.pinned_posts_table', compact('custom_posts', 'block'))->render();
        $all_post_table    = view('block.all_posts_table', compact('custom_posts', 'block'))->render();

        return ['success' => true, 'custom_posts_table' => $custom_post_table, 'all_post_table' => $all_post_table];
    }

    /**
     * store custom posts
     *
     * @param Request $request
     * @param         $blockId
     *
     * @return array
     */
    public function unpin(Request $request, $blockId)
    {
        $block = $this->blockService->find($blockId);
        if ($block->custom_posts()->detach($request->get('post_id'))) {
            $block             = $this->blockService->find($blockId);
            $custom_posts      = $block->custom_posts;
            $custom_post_table = view('block.pinned_posts_table', compact('custom_posts', 'block'))->render();
            $all_post_table    = view('block.all_posts_table', compact('custom_posts', 'block'))->render();

            return ['success' => true, 'custom_posts_table' => $custom_post_table, 'all_post_table' => $all_post_table];
        }

        return ['success' => false];
    }
}
