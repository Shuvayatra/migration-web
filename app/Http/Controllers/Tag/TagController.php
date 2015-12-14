<?php

namespace App\Http\Controllers\Tag;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Nrna\Services\TagService;
use App\Http\Requests\TagRequest;
use Session;

class TagController extends Controller
{
    /**
     * @var TagService
     */
    private $tag;

    /**
     * constructor
     * @param TagService $tag
     */
    function __construct(TagService $tag)
    {
        $this->middleware('auth');
        $this->tag = $tag;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = $this->tag->all();

        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created tag in database.
     *
     * @param TagRequest $request
     * @return Response
     */
    public function store(TagRequest $request)
    {
        if ($this->tag->save($request->all())) {
            return redirect()->route('tag.index')->with('success', 'Tag saved successfully.');
        };

        return redirect('tag')->with('error', 'There is some problem saving tag.');
    }

    /**
     * Display the specified tag.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $tag = $this->tag->find($id);

        if (is_null($tag)) {
            return redirect()->route('tag.index')->with('error', 'Tag not found.');
        }

        return view('tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $tag = $this->tag->find($id);
        if (is_null($tag)) {
            return redirect()->route('tag.index')->with('error', 'Tag not found.');
        }

        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int       $id
     * @param TagRequest $request
     * @return Response
     */
    public function update($id, TagRequest $request)
    {
        $tag = $this->tag->find($id);
        if (is_null($tag)) {
            return redirect()->route('tag.index')->with('error', 'Tag not found.');
        }
        if ($tag->update($request->all())) {
            return redirect('tag')->with('success', 'Tag successfully updated!');
        }

        return redirect('tag')->with('error', 'Problem updating Tag!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->tag->delete($id)) {
            return redirect('tag')->with('success', 'Tag successfully deleted!');
        }

        return redirect('tag')->with('error', 'Error deleting Tag !');
    }

}
