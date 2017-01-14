<?php

namespace App\Http\Controllers\Screen;

use App\Http\Requests\ScreenFeedRequest;
use App\Http\Requests\ScreenRequest;
use App\Nrna\Models\Category;
use App\Nrna\Services\CountryService;
use App\Nrna\Services\ScreenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeedController extends Controller
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
     * @param $screenId
     *
     * @return Response
     */
    public function create($screenId)
    {
        if (!$screen = $this->screen->getDetail($screenId)) {
            return abort(500);
        }

        return view('screen.feed_category_form', compact('screen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param               $screenId
     * @param ScreenRequest $request
     *
     * @return Response
     */
    public function store($screenId, ScreenFeedRequest $request)
    {
        if ($this->screen->saveCategories($screenId, $request->all())) {
            return redirect()->route('screen.index')->with('success', 'Screen saved successfully.');
        };

        return back()->with('error', 'There is some problem saving screen.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $screenId
     *
     * @return Response
     */
    public function edit($screenId, $id)
    {
        if (!$screen = $this->screen->getDetail($screenId)) {
            return abort(500);
        }

        return view('screen.feed_category_form', compact('screen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScreenRequest $request
     * @param  int          $screenId
     *
     * @return Response
     */
    public function update(ScreenFeedRequest $request, $screenId, $id)
    {
        if ($this->screen->updateCategories($screenId, $request->all())) {
            return redirect()->route('screen.index')->with('success', 'Screen updated successfully.');
        };

        return back()->with('error', 'There is some problem updating screen.');
    }
}
