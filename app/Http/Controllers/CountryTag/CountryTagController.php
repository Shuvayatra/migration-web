<?php

namespace App\Http\Controllers\CountryTag;

use App\Http\Controllers\Controller;
use App\Nrna\Services\CountryTagService;
use App\Http\Requests\CountryTagRequest;

class CountryTagController extends Controller
{
    /**
     * @var CountryTagService
     */
    private $countrytag;

    /**
     * constructor
     * @param CountryTagService $countrytag
     */
    public function __construct(CountryTagService $countrytag)
    {
        $this->middleware('auth');
        $this->countrytag = $countrytag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $countrytags = $this->countrytag->all();

        return view('countrytag.index', compact('countrytags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('countrytag.create');
    }

    /**
     * Store a newly created countrytag in database.
     *
     * @param  CountryTagRequest $request
     * @return Response
     */
    public function store(CountryTagRequest $request)
    {
        if ($this->countrytag->save($request->all())) {
            return redirect()->route('countrytag.index')->with('success', 'Country Tag saved successfully.');
        };

        return redirect('countrytag')->with('error', 'There is some problem saving country tag.');
    }

    /**
     * Display the specified countrytag.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $countrytag = $this->countrytag->find($id);

        if (is_null($countrytag)) {
            return redirect()->route('countrytag.index')->with('error', 'Country Tag not found.');
        }

        return view('countrytag.show', compact('countrytag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $countrytag = $this->countrytag->find($id);
        if (is_null($countrytag)) {
            return redirect()->route('countrytag.index')->with('error', 'Country Tag not found.');
        }

        return view('countrytag.edit', compact('countrytag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int               $id
     * @param  CountryTagRequest $request
     * @return Response
     */
    public function update($id, CountryTagRequest $request)
    {
        $countrytag = $this->countrytag->find($id);
        if (is_null($countrytag)) {
            return redirect()->route('countrytag.index')->with('error', 'Country Tag not found.');
        }
        if ($countrytag->update($request->all())) {
            return redirect('countrytag')->with('success', 'Country Tag successfully updated!');
        }

        return redirect('countrytag')->with('error', 'Problem updating CountryTag!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->countrytag->delete($id)) {
            return redirect('countrytag')->with('success', 'Country Tag successfully deleted!');
        }

        return redirect('countrytag')->with('error', 'Error deleting Country Tag !');
    }
}
