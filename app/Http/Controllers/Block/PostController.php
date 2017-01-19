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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @param         $blockId
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
            return ['success' => true];
        }

        return ['success' => false];
    }
}
