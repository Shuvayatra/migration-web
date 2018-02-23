<?php

namespace App\Http\Controllers\PushNotificationGroup;


use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotificationGroupRequest;
use App\Nrna\Services\PushNotificationGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PushNotificationGroupController extends Controller
{
    /**
     * @var PushNotificationGroupService
     */
    private $pushNotificationGroup;

    /**
     * @param PushNotificationGroupService $pushNotificationGroup
     */
    public function __construct(PushNotificationGroupService $pushNotificationGroup)
    {
        $this->pushNotificationGroup = $pushNotificationGroup;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pushnotificationgroups = $this->pushNotificationGroup->getAll();

        return view('pushnotificationgroup.index', compact('pushnotificationgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $destinations = \App\Nrna\Models\Category::where('parent_id', '=', 1)->where('title_en', '<>', '')->get();
        return view('pushnotificationgroup.create', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PushNotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PushNotificationGroupRequest $request)
    {
        $allEmpty = true;
        foreach($request->input('properties') as $property){

            if(!empty($property)){

                $allEmpty = false;
                break;
            }
        }

        if($allEmpty){

            return redirect('pushnotificationgroup/create')->with('error', 'Please select at least one property.');
        }

        $this->pushNotificationGroup->create($request->all());

        return redirect('pushnotificationgroup')->with('success', 'Push notification Group successfully saved!');
    }

    /**
     * Show the form for editing the specified pushNotificationGroup.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $destinations = \App\Nrna\Models\Category::where('parent_id', '=', 1)->where('title_en', '<>', '')->get();
        $pushnotificationgroup = $this->pushNotificationGroup->find($id);
        $properties = json_decode($pushnotificationgroup->properties);
        if (!$pushnotificationgroup) {
            return redirect()->back()->with('error', 'PushNotificationGroup not found.');
        }

        return view('pushnotificationgroup.edit', compact('pushnotificationgroup', 'properties', 'destinations'));
    }

    /**
     * Update the specified pushNotificationGroup in storage.
     *
     * @param  int      $id
     * @param  Request  $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $allEmpty = true;
        foreach($request->input('properties') as $property){

            if(!empty($property)){

                $allEmpty = false;
                break;
            }
        }

        if($allEmpty){

            return redirect('pushnotificationgroup/create')->with('error', 'Please select at least one property.');
        }
        $pushNotificationGroup = $this->pushNotificationGroup->find($id);
        if (!$pushNotificationGroup) {
            return redirect('pushnotificationgroup')->with('error', 'PushNotificationGroup not found.');
        }

        $request->request->set('properties', json_encode($request->request->get('properties')));
        if (!$pushNotificationGroup->update($request->all())) {
            return redirect('pushnotificationgroup')->with('error', 'Problem editing PushNotificationGroup.');
        }

        return redirect('pushnotificationgroup')->with('success', 'PushNotificationGroup successfully updated!');
    }

    /**
     * Remove the specified pushNotificationGroup from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!$this->pushNotificationGroup->delete($id)) {
            return redirect()->back()->with('error', 'Problem deleting PushNotificationGroup.');
        }

        return redirect()->back()->with('success', 'PushNotificationGroup successfully deleted!');
    }
}