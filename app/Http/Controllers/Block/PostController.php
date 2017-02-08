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

        if (is_null($request->get('posts'))) {
            $posts = [];
        } else {
            $posts = $request->get('posts');
        }
        if ($block->custom_posts()->sync($posts)) {
            $custom_posts      = $block->custom_posts();
            $custom_post_table = view('block.pinned_posts_table', compact('custom_posts'))->render();

            return ['success' => true, 'custom_posts_table' => $custom_post_table];
        }

        return ['success' => false];
    }
}
