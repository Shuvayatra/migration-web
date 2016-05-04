<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Nrna\Models\Category;
use Illuminate\Http\Request;
use App\Nrna\Services\CategoryService;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $category;

    /**
     * constructor
     * @param CategoryService $category
     */
    public function __construct(CategoryService $category)
    {
        $this->middleware('auth');
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param         $parent_id
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->category->all($request->all());

        return view('category.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in database.
     *
     * @param                  $parent_id
     * @param  CategoryRequest $request
     * @return Response
     */
    public function store($parent_id, CategoryRequest $request)
    {
        if ($this->category->save($request->all(), $parent_id)) {
            return redirect()->route('category.show', $parent_id)->with(
                'success',
                'Category saved successfully.'
            );
        };

        return redirect()->route('category')->with('error', 'There is some problem saving category.');
    }

    /**
     * Display the specified category.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $category = $this->category->find($id);

        if (is_null($category)) {
            return redirect()->route('category.index', $id)->with(
                'error',
                'Category not found.'
            );
        }

        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param      $parent_id
     * @param  int $id
     * @return Response
     */
    public function edit($parent_id, $id)
    {
        $category = $this->category->find($id);
        if (is_null($category)) {
            return redirect()->route('category.show', $parent_id)->with(
                'error',
                'Category not found.'
            );
        }

        return view('category.edit', compact('category', 'parent_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int             $id
     * @param  CategoryRequest $request
     * @return Response
     */
    public function update($parent_id, $id, CategoryRequest $request)
    {
        $category = $this->category->find($id);
        if (is_null($category)) {
            return redirect()->route('category.show', $parent_id)->with(
                'error',
                'Category not found.'
            );
        }
        if ($category->update($request->all())) {
            return redirect()->route('category.show', $parent_id)->with(
                'success',
                'Category successfully updated!'
            );
        }

        return redirect()->route('category.show', $parent_id)->with(
            'error',
            'Problem updating Category!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param      $parent_id
     * @param  int $id
     * @return Response
     */
    public function destroy($parent_id, $id)
    {
        if ($this->category->delete($id)) {
            return redirect()->route('category.show', $parent_id)->with(
                'success',
                'Category successfully deleted!'
            );
        }

        return redirect()->route('category.show', $parent_id)->with(
            'error',
            'Error deleting Category !'
        );
    }
}
