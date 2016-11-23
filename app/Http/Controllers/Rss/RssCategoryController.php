<?php

namespace App\Http\Controllers\Rss;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\RssCategoryRequest;
use App\Nrna\Models\RssCategory;
use App\Nrna\Services\FileUpload;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class RssCategoryController extends Controller
{
    /**
     * @var FileUpload
     */
    private $fileUpload;

    /**
     * RssCategoryController constructor.
     *
     * @param FileUpload $fileUpload
     */
    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $rss_categories = RssCategory::all();

        return view('rss_category.index', compact('rss_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('rss_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(RssCategoryRequest $request)
    {
        $data          = $request->all();
        $data['image'] = $this->fileUpload->handle($request->file('image'));
        RssCategory::create($data);
        Session::flash('success', 'Category added!');

        return redirect('rss_category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function show($id)
    {
        $rss_category = RssCategory::findOrFail($id);

        return view('rss_category.show', compact('rss_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function edit($id)
    {
        $rss_category = RssCategory::findOrFail($id);

        return view('rss_category.edit', compact('rss_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     *
     * @param Request $request
     */
    public function update($id, RssCategoryRequest $request)
    {
        $rss_category = RssCategory::findOrFail($id);
        $data         = $request->all();
        if ($request->file('image')) {
            $data['image'] = $this->fileUpload->handle($request->file('image'))['filename'];
        }

        $rss_category->update($data);

        Session::flash('success', 'Category updated!');

        return redirect('rss_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        RssCategory::destroy($id);

        Session::flash('success', 'Category deleted!');

        return redirect('rss_category');
    }
}
