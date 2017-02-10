<?php

namespace App\Http\Controllers\Page;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PageRequest;
use App\Nrna\Models\Page;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $pages = Page::paginate(15);

        return view('page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     */
    public function store(PageRequest $request)
    {
        Page::create($request->all());

        Session::flash('success', 'Page added!');

        return redirect('pages');
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
        $page = Page::findOrFail($id);

        return view('page.show', compact('page'));
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
        $page = Page::findOrFail($id);

        return view('page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return void
     */
    public function update($id, PageRequest $request)
    {

        $page = Page::findOrFail($id);
        $page->update($request->all());

        Session::flash('success', 'Page updated!');

        return redirect('pages');
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
        Page::destroy($id);

        Session::flash('success', 'Page deleted!');

        return redirect('pages');
    }
}
