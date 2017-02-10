<?php

namespace App\Http\Controllers\Screen;

use App\Http\Requests\ScreenRequest;
use App\Nrna\Models\Category;
use App\Nrna\Services\CountryService;
use App\Nrna\Services\ScreenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ScreenController extends Controller
{
    /**
     * @var ScreenService
     */
    protected $screen;
    /**
     * @var CountryService
     */
    protected $country;

    /**
     * ScreenController constructor.
     *
     * @param ScreenService  $screen
     * @param CountryService $country
     */
    public function __construct(ScreenService $screen, CountryService $country)
    {
        $this->screen  = $screen;
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $screens = $this->screen->getAll();

        return view('screen.index', compact('screens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $gender       = config('screen.gender');
        $publishState = config('screen.state');
        $countries    = Category::where('section', 'country')->first()->getImmediateDescendants()->lists('title', 'id')->toArray();
        $countries    = ['all' => 'All Countries'] + $countries;

        return view('screen.create', compact('countries', 'gender', 'publishState'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param ScreenRequest $request
     *
     * @return Response
     */
    public function store(ScreenRequest $request)
    {
        if ($this->screen->save($request->all())) {
            return redirect()->route('screen.index')->with('success', 'Screen saved successfully.');
        };

        return back()->with('error', 'There is some problem saving screen.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $screenId
     *
     * @return Response
     */
    public function edit($screenId)
    {
        $screen       = $this->screen->find($screenId);
        $countries    = Category::where('section', 'country')->first()->getImmediateDescendants()->lists('title', 'id')->toArray();
        $countries    = ['all' => 'All Countries'] + $countries;
        $gender       = config('screen.gender');
        $publishState = config('screen.state');

        return view('screen.edit', compact('screen', 'countries', 'gender', 'publishState'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScreenRequest $request
     * @param  int          $screenId
     *
     * @return Response
     */
    public function update(ScreenRequest $request, $screenId)
    {
        if ($this->screen->update($screenId, $request->all())) {
            return redirect()->route('screen.index')->with('success', 'Screen updated successfully.');
        };

        return back()->with('error', 'There is some problem updating screen.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $screenId
     *
     * @return Response
     */
    public function destroy($screenId)
    {
        if ($this->screen->delete($screenId)) {
            return redirect()->back()->with('success', 'Screen deleted successfully.');
        }

        return back()->with('error', 'There is some problem updating screen.');
    }

}
