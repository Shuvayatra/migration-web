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

class BlockController extends Controller
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
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $blocks = $this->blockService->all(request()->all());

        return view('block.index', compact('blocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('block.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BlockRequest $request)
    {
        $data = $request->except('_token');
        if ($this->blockService->save($data)) {
            Session::flash('success', 'Block added!');
            $request_query = ['page' => request()->get('page', 'home')];
            if (request()->get('page') == 'destination') {
                $request_query = $request_query + ['country_id' => request()->get('country_id')];
            }
            if (request()->get('page') == 'dynamic') {
                $request_query = $request_query + ['screen_id' => request()->get('screen_id')];
            }

            return redirect()->route('blocks.index', $request_query);
        }
        Session::flash('error', 'Problem creating block !');

        return redirect()->route('blocks.index', $request_query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function show($id)
    {
        $blocks = Block::findOrFail($id);

        return view('block.show', compact('blocks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function edit($id)
    {
        $block = Block::findOrFail($id);

        return view('block.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     *
     * @param Request $request
     */
    public function update($id, BlockRequest $request)
    {
        $block = Block::findOrFail($id);
        $block->update($request->all());

        Session::flash('success', 'Block updated!');

        $request_query = ['page' => request()->get('page', 'home')];
        if (request()->get('page') == 'destination') {
            $request_query = $request_query + ['country_id' => request()->get('country_id')];
        }
        if (request()->get('page') == 'dynamic') {
            $request_query = $request_query + ['screen_id' => request()->get('screen_id')];
        }

        return redirect()->route('blocks.index', $request_query);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Block::destroy($id);

        Session::flash('success', 'Block deleted!');

        return redirect()->back();
    }
}
