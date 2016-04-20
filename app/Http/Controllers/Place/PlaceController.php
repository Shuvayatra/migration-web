<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Nrna\Services\PlaceService;
use App\Http\Requests\PlaceRequest;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * @var PlaceService
     */
    private $place;

    /**
     * constructor
     * @param PlaceService $place
     */
    public function __construct(PlaceService $place)
    {
        $this->middleware('auth');
        $this->place = $place;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $places = $this->place->all();

        return view('place.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('place.create');
    }

    /**
     * Store a newly created.
     *
     * @param  PlaceRequest $request
     * @return Response
     */
    public function store(PlaceRequest $request)
    {
        if ($this->place->save($request->all())) {
            return redirect()->route('place.index')->with('success', 'Place saved successfully.');
        };

        return redirect('place')->with('error', 'There is some problem saving place.');
    }

    /**
     * Display the specified place.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $place = $this->place->find($id);

        if (is_null($place)) {
            return redirect()->route('place.index')->with('error', 'Place not found.');
        }

        return view('place.show', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $place = $this->place->find($id);
        if (is_null($place)) {
            return redirect()->route('place.index')->with('error', 'Place not found.');
        }

        return view('place.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int          $id
     * @param  PlaceRequest $request
     * @return Response
     */
    public function update($id, PlaceRequest $request)
    {
        $place = $this->place->find($id);
        if (is_null($place)) {
            return redirect()->route('place.index')->with('error', 'Place not found.');
        }
        if ($this->place->update($id, $request->all())) {
            return redirect('place')->with('success', 'Place successfully updated!');
        }

        return redirect('place')->with('error', 'Problem updating Place!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->place->delete($id)) {
            return redirect('place')->with('success', 'Place successfully deleted!');
        }

        return redirect('place')->with('error', 'Error deleting Place !');
    }
}
