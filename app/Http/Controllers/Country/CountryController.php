<?php

namespace App\Http\Controllers\Country;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Nrna\Models\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class CountryController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $countries = Country::paginate(15);

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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'code' => 'required', 'image' => 'required',]);

        Country::create($request->all());

        Session::flash('flash_message', 'Country successfully added!');

        return redirect('country');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);

        return view('country.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', 'code' => 'required', 'image' => 'required',]);

        $country = Country::findOrFail($id);
        $country->update($request->all());

        Session::flash('flash_message', 'Country successfully updated!');

        return redirect('country');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Country::destroy($id);

        Session::flash('flash_message', 'Country successfully deleted!');

        return redirect('country');
    }

}
