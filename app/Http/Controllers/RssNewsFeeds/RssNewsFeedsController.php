<?php

namespace App\Http\Controllers\RssNewsFeeds;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Nrna\Models\RssNewsFeeds;
use App\Nrna\Services\RssNewsFeedsService;
use App\Nrna\Services\RssService;
use Session;

class RssNewsFeedsController extends Controller
{
    /**
     * @var RssService
     */
    protected $rssService;

    /**
     * RssNewsFeedsController constructor.
     * @param RssNewsFeedsService $rssNewsFeeds
     * @param RssService          $rssService
     */
    public function __construct(RssNewsFeedsService $rssNewsFeeds, RssService $rssService)
    {
        $this->rssNewsFeeds = $rssNewsFeeds;
        $this->rssService   = $rssService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $rssnewsfeeds = $this->rssNewsFeeds->getAll();

        return view('rssnewsfeeds.index', compact('rssnewsfeeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('rssnewsfeeds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->rssNewsFeeds->save($request->all());

        return redirect('rssnewsfeeds')->with('success', 'Rss News Feeds successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $rssnewsfeed = $this->rssNewsFeeds->find($id);

        return view('rssnewsfeeds.show', compact('rssnewsfeed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $rssnewsfeed = $this->rssNewsFeeds->find($id);

        return view('rssnewsfeeds.edit', compact('rssnewsfeed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $rssnewsfeed = RssNewsFeeds::findOrFail($id);
        $rssnewsfeed->update($request->all());

        return redirect('rssnewsfeeds')->with('success', 'Rss News Feeds succesfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        RssNewsFeeds::destroy($id);

        return redirect('rssnewsfeeds');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fetch()
    {
        $rssList = $this->rssService->getRssList();
        foreach ($rssList as $rss) {
            $this->rssNewsFeeds->fetch($rss);
        }

        return redirect()->route('rssnewsfeeds.index')->with('success', 'Rss Feeds fetched successfully');
    }
}
