<?php

namespace App\Http\Controllers\Notice;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\NoticeRequest;
use App\Nrna\Models\Notice;
use App\Nrna\Services\FileUpload;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class NoticeController extends Controller
{
    /**
     * @var FileUpload
     */
    private $fileUpload;

    /**
     * NoticeController constructor.
     *
     * @param FileUpload $fileUpload
     */
    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
        $this->uploadPath = public_path('uploads/notice');
    }

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
     * @param Request $request
     */
    public function store(NoticeRequest $request)
    {
        $data           = $request->all();
        $data['status'] = $request->has('status');
        if (isset($data['metadata']['image'])) {
            $main_image_info           = $this->fileUpload->handle(
                $data['metadata']['image'],
                $this->uploadPath
            );
            $data['metadata']['image'] = $main_image_info['filename'];
        };
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
     * write brief description
     *
     * @param               $id
     * @param NoticeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, NoticeRequest $request)
    {
        $notice         = Notice::findOrFail($id);
        $data           = $request->all();
        $data['status'] = $request->has('status');
        if (isset($data['metadata']['image'])) {
            $main_image_info           = $this->fileUpload->handle(
                $data['metadata']['image'],
                $this->uploadPath
            );
            $data['metadata']['image'] = $main_image_info['filename'];
        } else {
            $data['metadata']['image'] = $notice->metadata->image;
        }
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
