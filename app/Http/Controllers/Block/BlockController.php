<?php

namespace App\Http\Controllers\Block;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Nrna\Models\Block;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $query = Block::sorted()->orderBy('page', 'desc');
        $query->where('page', request()->get('page', 'home'));

        if (request()->get('country_id') != '') {
            $query->whereRaw("metadata->>'country_id'=?", [request()->get('country_id')]);
        }
        if (request()->get('journey_id') != '') {
            $query->whereRaw("metadata->>'journey_id'=?", [request()->get('journey_id')]);
        }
        $blocks = $query->get();

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
    public function store(Request $request)
    {
        Block::create($request->except('_token'));

        Session::flash('success', 'Block added!');
        $request_query = ['page' => request()->get('page', 'home')];
        if (request()->get('page') == 'destination') {
            $request_query = $request_query + ['country_id' => request()->get('country_id')];
        }

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
     * @param  int $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $block = Block::findOrFail($id);
        $block->update($request->all());

        Session::flash('success', 'Block updated!');

        $request_query = ['page' => request()->get('page', 'home')];
        if (request()->get('page') == 'destination') {
            $request_query = $request_query + ['country_id' => request()->get('country_id')];
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
