<?php

namespace App\Http\Controllers\Rss;

use App\Http\Requests\RssRequest;
use App\Nrna\Models\Rss;
use App\Nrna\Services\RssService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class RssController extends Controller
{
    /**
     * @var RssService
     */
    private $rssService;

    /**
     * RssController constructor.
     * @param RssService $rssService
     */
    public function __construct(RssService $rssService)
    {
        $this->rssService = $rssService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $rsses = Rss::paginate(15);

        return view('rss.index', compact('rsses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('rss.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RssRequest $request
     * @return Response
     */
    public function store(RssRequest $request)
    {
        $this->rssService->save($request->all());

        return redirect('rss')->with('success', 'Rss added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $rss = $this->rssService->find($id);
        $rssItems = $this->rssService->getRssItems($rss->url);
        dd($rssItems);

        return view('rss.show', compact('rss', 'rssItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $rss = Rss::findOrFail($id);

        return view('rss.edit', compact('rss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {

        $rss = Rss::findOrFail($id);
        $rss->update($request->all());

        Session::flash('flash_message', 'Rss successfully updated!');

        return redirect('rss');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Rss::destroy($id);

        Session::flash('flash_message', 'Rss successfully deleted!');

        return redirect('rss');
    }
}