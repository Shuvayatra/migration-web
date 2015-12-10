<?php

namespace App\Http\Controllers\Question;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\QuestionRequest;
use App\Nrna\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questions = Question::paginate(15);

        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionRequest $request
     * @return Response
     */
    public function store(QuestionRequest $request)
    {
        Question::create($request->all());

        Session::flash('flash_message', 'Question successfully added!');

        return redirect('question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        return view('question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param QuestionRequest $request
     * @return Response
     */
    public function update($id, QuestionRequest $request)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());

        Session::flash('flash_message', 'Question successfully updated!');

        return redirect('question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Question::destroy($id);

        Session::flash('flash_message', 'Question successfully deleted!');

        return redirect('question');
    }

}
