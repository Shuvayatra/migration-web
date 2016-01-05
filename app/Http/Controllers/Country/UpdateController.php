<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use App\Nrna\Services\CountryUpdateService;

class UpdateController extends Controller
{
    /**
     * @var CountryUpdateService
     */
    private $update;

    /**
     * @param CountryUpdateService $update
     */
    public function __construct(CountryUpdateService $update)
    {
        $this->update = $update;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $updates = $this->update->all();

        return view('update.index', compact('updates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('update.create');
    }

    /**
     * Store a newly created.
     *
     * @param  updateRequest $request
     * @return Response
     */
    public function store(UpdateRequest $request)
    {
        if ($this->update->save($request->all())) {
            return redirect()->route('update.index')->with('success', 'Country update saved successfully.');
        };

        return redirect('update')->with('error', 'There is some problem saving country update.');
    }

    /**
     * Display the specified update.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $update = $this->update->find($id);

        if (is_null($update)) {
            return redirect()->route('update.index')->with('error', 'Country Update not found.');
        }

        return view('update.show', compact('update'));
    }

    /**
     * Show the form for editing the specified update.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $update = $this->update->find($id);
        if (!$update) {
            return redirect()->back()->with('error', 'Country Update not found.');
        }

        return view('update.edit', compact('update'));
    }

    /**
     * Update the specified update in storage.
     *
     * @param  int           $id
     * @param  UpdateRequest $request
     * @return Response
     */
    public function update($id, UpdateRequest $request)
    {
        $update = $this->update->find($id);
        if (!$update) {
            return redirect()->back()->with('error', 'Country Update not found.');
        }

        if (!$update->update($request->all())) {
            return redirect()->back()->with('error', 'Problem editing Country Update.');
        }

        return redirect()->back()->with('success', 'Country Update successfully updated!');
    }

    /**
     * Remove the specified update from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!$this->update->delete($id)) {
            return redirect()->back()->with('error', 'Problem deleting Country Update.');
        }

        return redirect()->back()->with('success', 'Country Update successfully deleted!');
    }

}
