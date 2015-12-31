<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Nrna\Services\CountryService;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{
    /**
     * @var CountryService
     */
    private $country;

    /**
     * constructor
     * @param CountryService $country
     */
    public function __construct(CountryService $country)
    {
        $this->middleware('auth');
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $countries = $this->country->all();

        return view('country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('country.create');
    }

    /**
     * Store a newly created.
     *
     * @param  CountryRequest $request
     * @return Response
     */
    public function store(CountryRequest $request)
    {
        if ($this->country->save($request->all())) {
            return redirect()->route('country.index')->with('success', 'Country saved successfully.');
        };

        return redirect('country')->with('error', 'There is some problem saving country.');
    }

    /**
     * Display the specified country.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        $country = $this->country->find($id);

        if (is_null($country)) {
            return redirect()->route('country.index')->with('error', 'Country not found.');
        }

        return view('country.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $country = $this->country->find($id);
        if (is_null($country)) {
            return redirect()->route('country.index')->with('error', 'Country not found.');
        }

        return view('country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  CountryRequest $request
     * @return Response
     */
    public function update($id, CountryRequest $request)
    {
        $country = $this->country->find($id);
        if (is_null($country)) {
            return redirect()->route('country.index')->with('error', 'Country not found.');
        }
        if ($this->country->update($id, $request->all())) {
            return redirect('country')->with('success', 'Country successfully updated!');
        }

        return redirect('country')->with('error', 'Problem updating Country!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->country->delete($id)) {
            return redirect('country')->with('success', 'Country successfully deleted!');
        }

        return redirect('country')->with('error', 'Error deleting Country !');
    }
}
