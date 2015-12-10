<?php

namespace App\Http\Controllers\Tag;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Nrna\Services\TagService;
use Illuminate\Http\Request;
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
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return Response
     */
    public function store(TagRequest $request)
    {
        if ($this->tag->save($request->all())) {
            return redirect()->route('tag.index')->withSuccess('Tag saved successfully.');
        };

        return redirect('tag')->withError('There is some problem saving tag.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);

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
        $tag = Tag::findOrFail($id);

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
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());

        Session::flash('flash_message', 'Tag successfully updated!');

        return redirect('tag');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);

        Session::flash('flash_message', 'Tag successfully deleted!');

        return redirect('tag');
    }

}
