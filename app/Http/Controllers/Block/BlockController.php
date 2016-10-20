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
        $block = Block::paginate(15);

        return view('block.index', compact('block'));
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
     * @return void
     */
    public function store(Request $request)
    {

        Block::create($request->all());

        Session::flash('flash_message', 'Block added!');

        return redirect('block');
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
        $block = Block::findOrFail($id);

        return view('block.show', compact('block'));
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

        Session::flash('flash_message', 'Block updated!');

        return redirect('block');
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

        Session::flash('flash_message', 'Block deleted!');

        return redirect('block');
    }
}
