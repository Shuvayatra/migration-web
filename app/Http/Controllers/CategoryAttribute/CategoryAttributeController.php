<?php

namespace App\Http\Controllers\CategoryAttribute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Nrna\Services\CategoryAttributeService;
use App\Http\Requests\CategoryAttributeRequest;

class CategoryAttributeController extends Controller
{
    /**
     * @var CategoryAttributeService
     */
    private $categoryattribute;

    /**
     * constructor
     * @param CategoryAttributeService $categoryattribute
     */
    public function __construct(CategoryAttributeService $categoryattribute)
    {
        $this->middleware('auth');
        $this->categoryattribute = $categoryattribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param         $section_id
     * @return Response
     */
    public function index(Request $request, $section_id)
    {
        $categoryattributes = $this->categoryattribute->all($section_id, $request->all());

        return view('categoryattribute.index', compact('categoryattributes', 'section_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $section_id
     * @return Response
     */
    public function create($section_id)
    {
        return view('categoryattribute.create', compact('section_id'));
    }

    /**
     * Store a newly created categoryattribute in database.
     *
     * @param  CategoryAttributeRequest $request
     * @return Response
     */
    public function store($section_id, CategoryAttributeRequest $request)
    {
        if ($this->categoryattribute->save($section_id, $request->all())) {
            return redirect()->route('section.category.index', $section_id)->with(
                'success',
                'CategoryAttribute saved successfully.'
            );
        };

        return redirect()->route('categoryattribute')->with('error', 'There is some problem saving categoryattribute.');
    }

    /**
     * Display the specified categoryattribute.
     *
     * @param  int $id
     * @return Response
     */
    public function show($section_id, $id)
    {
        $categoryattribute = $this->categoryattribute->find($id);

        if (is_null($categoryattribute)) {
            return redirect()->route('section.category.index', $section_id)->with(
                'error',
                'CategoryAttribute not found.'
            );
        }

        return view('categoryattribute.show', compact('categoryattribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param      $section_id
     * @param  int $id
     * @return Response
     */
    public function edit($section_id, $id)
    {
        $categoryattribute = $this->categoryattribute->find($id);
        if (is_null($categoryattribute)) {
            return redirect()->route('section.category.index', $section_id)->with(
                'error',
                'CategoryAttribute not found.'
            );
        }

        return view('categoryattribute.edit', compact('categoryattribute', 'section_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                      $id
     * @param  CategoryAttributeRequest $request
     * @return Response
     */
    public function update($section_id, $id, CategoryAttributeRequest $request)
    {
        $categoryattribute = $this->categoryattribute->find($id);
        if (is_null($categoryattribute)) {
            return redirect()->route('section.category.index', $section_id)->with(
                'error',
                'CategoryAttribute not found.'
            );
        }
        if ($this->categoryattribute->update($id, $request->all())) {
            return redirect()->route('section.category.index', $section_id)->with(
                'success',
                'CategoryAttribute successfully updated!'
            );
        }

        return redirect()->route('section.category.index', $section_id)->with(
            'error',
            'Problem updating CategoryAttribute!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param      $section_id
     * @param  int $id
     * @return Response
     */
    public function destroy($section_id, $id)
    {
        if ($this->categoryattribute->delete($id)) {
            return redirect()->route('section.category.index', $section_id)->with(
                'success',
                'CategoryAttribute successfully deleted!'
            );
        }

        return redirect()->route('section.category.index', $section_id)->with(
            'error',
            'Error deleting CategoryAttribute !'
        );
    }
}
