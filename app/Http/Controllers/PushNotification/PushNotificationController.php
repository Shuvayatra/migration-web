<?php

namespace App\Http\Controllers\PushNotification;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PushNotificationRequest;
use App\Nrna\Models\PushNotification;
use App\Nrna\Services\PostService;
use App\Nrna\Services\PushNotificationService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * @var PostService
     */
    protected $postService;
    /**
     * @var PushNotificationService
     */
    protected $pushNotificationService;

    /**
     * PushNotificationController constructor.
     * @param PostService             $postService
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(PostService $postService, PushNotificationService $pushNotificationService)
    {
        $this->postService             = $postService;
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pushnotifications = $this->pushNotificationService->getAll();

        return view('pushnotification.index', compact('pushnotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $contentOptions = $this->getContentOptions();

        return view('pushnotification.create', compact('contentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PushNotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PushNotificationRequest $request)
    {
        $result = $this->pushNotificationService->sendNotification($request->all());

        $this->pushNotificationService->create(array_merge($request->all(), ['response' => $result]));

        return redirect('pushnotification')->with('success', 'Push notification successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $pushnotification = $this->pushNotificationService->find($id);

        return view('pushnotification.show', compact('pushnotification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $pushnotification = $this->pushNotificationService->find($id);
        $contentOptions   = $this->getContentOptions();


        return view('pushnotification.edit', compact('pushnotification', 'contentOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $pushnotification = $this->pushNotificationService->find($id);
        $result           = $this->pushNotificationService->sendNotification($request->all());

        $pushnotification->update(array_merge($request->all(), ['response' => $result]));

        return redirect('pushnotification')->with('success', 'Push notification resend was successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->pushNotificationService->destroy($id);

        return redirect('pushnotification')->with('success', 'Push notification successfully deleted!');
    }

    /**
     * @return array
     */
    public function getContentOptions()
    {
        $contentOptions = [];
        $posts          = $this->postService->getAllPosts();
        foreach ($posts as $post) {
            $contentOptions[$post->id] = $post->metadata->title;
        }

        return $contentOptions;
    }
}
