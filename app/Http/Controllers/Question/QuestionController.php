<?php

namespace App\Http\Controllers\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nrna\Services\QuestionService;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    /**
     * @var QuestionService
     */
    private $question;

    /**
     * constructor
     * @param QuestionService $question
     */
    public function __construct(QuestionService $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questions = $this->question->allParents();

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
     * Store a newly created.
     *
     * @param  QuestionRequest $request
     * @return Response
     */
    public function store(QuestionRequest $request)
    {
        if ($this->question->save($request->all())) {
            return redirect()->route('question.index')->with('success', 'Question saved successfully.');
        };

        return redirect('question')->with('error', 'There is some problem saving question.');
    }

    /**
     * Display the specified question.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $question = $this->question->find($id);

        if (is_null($question)) {
            return redirect()->route('question.index')->with('error', 'Question not found.');
        }

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
        $question = $this->question->find($id);
        if (is_null($question)) {
            return redirect()->route('question.index')->with('error', 'Question not found.');
        }

        return view('question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int             $id
     * @param  QuestionRequest $request
     * @return Response
     */
    public function update($id, QuestionRequest $request)
    {
        $question = $this->question->find($id);
        if (is_null($question)) {
            return redirect()->route('question.index')->with('error', 'Question not found.');
        }
        if ($this->question->update($id, $request->all())) {
            return redirect('question')->with('success', 'Question successfully updated!');
        }

        return redirect('question')->with('error', 'Problem updating Question!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->question->delete($id)) {
            return redirect('question')->with('success', 'Question successfully deleted!');
        }

        return redirect('question')->with('error', 'Error deleting Question !');
    }

    /**
     * @param  Requests $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function questionAnswers(Request $request)
    {
        if (!$request->has('question')) {
            return response('error');
        }
        $question = $this->question->find($request->get('question'));

        return view('question.partials.answers', compact('question'));
    }
}
