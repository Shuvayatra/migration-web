<?php

namespace App\Http\Controllers\Block;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\BlockRequest;
use App\Nrna\Models\Block;
use App\Nrna\Services\BlockService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class BlockController extends Controller
{

    /**
     * @var BlockService
     */
    private $blockService;


    /**
     * BlockController constructor.
     *
     * @param BlockService $blockService
     */
    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $blocks = $this->blockService->all(request()->all());

        return view('block.index', compact('blocks'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('block.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param BlockRequest|Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BlockRequest $request)
    {
        $data = $request->except('_token');
        if ($this->blockService->save($data)) {
            Session::flash('success', 'Block added!');
            $request_query = [ 'page' => request()->get('page', 'home') ];
            if (request()->get('page') == 'destination') {
                $request_query = $request_query + [ 'country_id' => request()->get('country_id') ];
            }
            if (request()->get('page') == 'dynamic') {
                $request_query = $request_query + [ 'screen_id' => request()->get('screen_id') ];
            }

            return redirect()->route('blocks.index', $request_query);
        }
        Session::flash('error', 'Problem creating block !');

        return redirect()->route('blocks.index', $request_query);
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
        $block = Block::findOrFail($id);

        return view('block.show', compact('block'));
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
        $block = Block::findOrFail($id);

        return view('block.edit', compact('block'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     *
     * @param Request $request
     */
    public function update($id, BlockRequest $request)
    {
        $block = Block::findOrFail($id);
        if ($this->checkNewAndOrLogic($request, $block) || $this->checkNewCountry($request,
                $block) || $this->checkForNewCategory($request, $block) || $this->checkForNewPostType($request, $block)
        ) {
            $changes = true;
        } else {
            $changes = false;
        }
        $block->update($request->all());

        Session::flash('success', 'Block updated!');
        if ($changes && $block->custom_posts->count() > 0) {
            $block->custom_posts()->sync([]);
            Session::flash('success', 'Block information updated and all pinned posts has been removed from this block  
            .');
        }
        $request_query = [ $block->id,'page' => request()->get('page', 'home') ];
        if (request()->get('page') == 'destination') {
            $request_query = $request_query + [ 'country_id' => request()->get('country_id') ];
        }
        if (request()->get('page') == 'dynamic') {
            $request_query = $request_query + [ 'screen_id' => request()->get('screen_id') ];
        }

        return redirect()->route('blocks.show', $request_query);
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
        Block::destroy($id);

        Session::flash('success', 'Block deleted!');

        return redirect()->back();
    }


    /**
     * @param Request $request
     * @param Block   $block
     *
     * @return bool
     */
    public function checkForNewCategory(Request $request, Block $block)
    {

        $originalRequest = $request->all();
        $new_category_id = $originalRequest['metadata']['category_id'];
        $old_category_id = $block->metadata->category_id;

        return $this->checkForChanges($old_category_id, $new_category_id);

    }


    public function checkNewAndOrLogic(Request $request, Block $block)
    {

        $originalRequest = $request->all();
        if ( ! isset($originalRequest['metadata']['category'])) {
            $newLogic = false;
        } else {
            $newLogic = true;
        }
        if ( ! isset($block->metadata->category)) {
            $oldLogic = false;
        } else {
            $oldLogic = true;
        }

        if ($newLogic == $oldLogic) {
            return true;
        } else {
            return false;
        }

    }


    public function checkForNewPostType(Request $request, Block $block)
    {

        $originalRequest = $request->all();
        if (isset($block->metadata->post_type)) {
            $oldPostType = $block->metadata->post_type;
        } else {
            $oldPostType = false;
        }

        if (isset($originalRequest['metadata']['post_type'])) {
            $newPostType = $originalRequest['metadata']['post_type'];
        } else {
            $newPostType = false;
        }

        if ($oldPostType == $newPostType) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * @param $old_id
     * @param $new_id
     *
     * @return bool
     */
    public function checkForChanges($old_id, $new_id)
    {

        return (is_array($new_id) && is_array($old_id) && count($new_id) == count($old_id) && array_diff($new_id,
                $old_id) === array_diff($old_id, $new_id));
    }


    public function checkNewCountry(Request $request, Block $block)
    {
        $originalRequest = $request->all();
        $newcountry_type = $originalRequest['metadata']['country']['type'];
        $oldcountry_type = $block->metadata->country->type;
        $changeforcountry=true;
        if ($originalRequest['metadata']['country']['type'] === 'country') {
            $newcountry_type_country_id = $originalRequest['metadata']['country']['country_ids'];
            if (isset($block->metadata->country->country_ids)) {
                $oldcountry_type_country_id = $block->metadata->country->country_ids;
            } else {
                $oldcountry_type_country_id = '';
            }
            if ($newcountry_type_country_id == $oldcountry_type_country_id) {
                $changeforcountry = true;
            } else {
                $changeforcountry = false;
            }
        }

        if ($newcountry_type === $oldcountry_type && $changeforcountry) {

            return true;
        } else {
            return false;
        }

    }

}
