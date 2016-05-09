<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;

use App\Nrna\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var SearchService
     */
    private $search;

    /**
     * @param SearchService $search
     */
    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    /**
     * Search by keyword
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $results = $this->search->search($request->get('q'));

        return view('search.index', compact('results'));
    }
}
