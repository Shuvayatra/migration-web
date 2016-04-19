<?php

namespace App\Http\Controllers\Journey;

use App\Http\Controllers\Controller;
use App\Nrna\Services\JourneyService;
use App\Http\Requests\JourneyRequest;

class JourneyController extends Controller
{
    /**
     * @var JourneyService
     */
    private $journey;

    /**
     * constructor
     * @param JourneyService $journey
     */
    public function __construct(JourneyService $journey)
    {
        $this->middleware('auth');
        $this->journey = $journey;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $journeys = $this->journey->all();

        return view('journey.index', compact('journeys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('journey.create');
    }

    /**
     * Store a newly created.
     *
     * @param  JourneyRequest $request
     * @return Response
     */
    public function store(JourneyRequest $request)
    {
        if ($this->journey->save($request->all())) {
            return redirect()->route('journey.index')->with('success', 'Journey saved successfully.');
        };

        return redirect('journey')->with('error', 'There is some problem saving journey.');
    }

    /**
     * Display the specified journey.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        $journey = $this->journey->find($id);

        if (is_null($journey)) {
            return redirect()->route('journey.index')->with('error', 'Journey not found.');
        }

        return view('journey.show', compact('journey'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $journey = $this->journey->find($id);
        if (is_null($journey)) {
            return redirect()->route('journey.index')->with('error', 'Journey not found.');
        }

        return view('journey.edit', compact('journey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  JourneyRequest $request
     * @return Response
     */
    public function update($id, JourneyRequest $request)
    {
        $journey = $this->journey->find($id);
        if (is_null($journey)) {
            return redirect()->route('journey.index')->with('error', 'Journey not found.');
        }
        if ($this->journey->update($id, $request->all())) {
            return redirect('journey')->with('success', 'Journey successfully updated!');
        }

        return redirect('journey')->with('error', 'Problem updating Journey!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->journey->delete($id)) {
            return redirect('journey')->with('success', 'Journey successfully deleted!');
        }

        return redirect('journey')->with('error', 'Error deleting Journey !');
    }
}
