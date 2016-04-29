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
        $root = Category::find(1);
        $data = $root->getDescendantsAndSelf()->toHierarchy()->toArray();
        $this->recursive($data);
        $child1    = $root->descendants()->get();
        $ancestors = $root->getAncestors();
        dump($ancestors);
        dump($child1);

        $category = Category::paginate(15);

        return view('category.index', compact('category'));
    }

    public function recursive($data)
    {
        foreach ($data as $key => $value) {
            //If $value is an array.

            if (!empty($value['children'])) {
                dump($value['children']);
                //We need to loop through it.
                $this->recursive($value['children']);
            } else {
                //It is not an array, so print it out.
                dump($value['children']);
            }
        }
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

        Category::create($request->all());

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
     * @param  int $id
     *
     * @return void
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
