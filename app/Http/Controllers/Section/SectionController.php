<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Nrna\Services\SectionService;
use App\Http\Requests\SectionRequest;

class SectionController extends Controller
{
    /**
     * @var SectionService
     */
    private $section;

    /**
     * constructor
     * @param SectionService $section
     */
    public function __construct(SectionService $section)
    {
        $this->middleware('auth');
        $this->section = $section;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sections = $this->section->all();

        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('section.create');
    }

    /**
     * Store a newly created section in database.
     *
     * @param  SectionRequest $request
     * @return Response
     */
    public function store(SectionRequest $request)
    {
        if ($this->section->save($request->all())) {
            return redirect()->route('section.index')->with('success', 'Section saved successfully.');
        };

        return redirect('section')->with('error', 'There is some problem saving section.');
    }

    /**
     * Display the specified section.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $section = $this->section->find($id);

        if (is_null($section)) {
            return redirect()->route('section.index')->with('error', 'Section not found.');
        }

        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $section = $this->section->find($id);
        if (is_null($section)) {
            return redirect()->route('section.index')->with('error', 'Section not found.');
        }

        return view('section.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  SectionRequest $request
     * @return Response
     */
    public function update($id, SectionRequest $request)
    {
        $section = $this->section->find($id);
        if (is_null($section)) {
            return redirect()->route('section.index')->with('error', 'Section not found.');
        }
        if ($section->update($request->all())) {
            return redirect('section')->with('success', 'Section successfully updated!');
        }

        return redirect('section')->with('error', 'Problem updating Section!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->section->delete($id)) {
            return redirect('section')->with('success', 'Section successfully deleted!');
        }

        return redirect('section')->with('error', 'Error deleting Section !');
    }
}
