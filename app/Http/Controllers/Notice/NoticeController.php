<?php

namespace App\Http\Controllers\Notice;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Nrna\Models\Notice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $notices = Notice::orderBy('created_at', 'desc')->get();

        return view('notice.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $data               = $request->all();
        $data['status']     = $request->has('status');
        Notice::create($data);

        Session::flash('success', 'Notice added!');

        return redirect('notice');
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
        $notice = Notice::findOrFail($id);

        return view('notice.show', compact('notice'));
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
        $notice = Notice::findOrFail($id);

        return view('notice.edit', compact('notice'));
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
        $notice             = Notice::findOrFail($id);
        $data               = $request->all();
        $data['status']     = $request->has('status');
        $notice->update($data);

        Session::flash('success', 'Notice updated!');

        return redirect('notice');
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
        Notice::destroy($id);

        Session::flash('success', 'Notice deleted!');

        return redirect('notice');
    }
}
