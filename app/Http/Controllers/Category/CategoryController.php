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

        return view('category.index', compact('categories'));
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
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $parent_id = ($request->get('parent_id', null) == '') ? null : $request->get('parent_id', null);
        if (is_null($parent_id)) {
            $this->category->save($request->all(), null);

            return redirect()->route('category.show', null)->with(
                'success',
                'Category saved successfully.'
            );
        };
        if ($this->category->save($request->all(), $parent_id)) {
            $parent = $this->category->find($parent_id);
            $root   = $parent->getRoot();

            $parent_id = $root->id;

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
    public function edit($id)
    {
        $category = $this->category->find($id);

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int             $id
     * @param  CategoryRequest $request
     * @return Response
     */
    public function update($id, CategoryRequest $request)
    {
        $category = $this->category->find($id);

        if ($this->category->update($id, $request->all())) {
            $root = $category->getRoot();

            $parent_id = $root->id;

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
    public function destroy($id)
    {
        if ($this->category->delete($id)) {
            return redirect()->back()->with(
                'success',
                'Category successfully deleted!'
            );
        }

        return redirect()->back()->with(
            'error',
            'Error deleting Category !'
        );
    }
}
