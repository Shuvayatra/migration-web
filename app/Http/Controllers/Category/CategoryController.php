<?php

namespace App\Http\Controllers\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $category = Category::paginate(15);

        return view('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $category = new Category();
        $category->fill($formData);
        $category->position = 0;
        $category->parent_id = ($request->get('parent_id', null) == '') ? null : $request->get('parent_id', null);
        $category->save();

        Session::flash('flash_message', 'Category added!');

        return redirect('category');
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
        $category = Category::findOrFail($id);

        return view('category.show', compact('category'));
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
        $category = Category::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     *
     * @param Request $request
     */
    public function update($id, Request $request)
    {

        $category = Category::findOrFail($id);
        $category->update($request->all());

        Session::flash('flash_message', 'Category updated!');

        return redirect('category');
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
        Category::destroy($id);

        Session::flash('flash_message', 'Category deleted!');

        return redirect('category');
    }
}
