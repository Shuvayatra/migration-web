<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Nrna\Models\Answer;
use App\Nrna\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * @var AnswerService
     */
    private $answer;

    /**
     * @param AnswerService $answer
     */
    public function __construct(AnswerService $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Show the form for editing the specified answer.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $answer = $this->answer->find($id);
        if (!$answer) {
            return redirect()->back()->with('error', 'Question not found.');
        }

        return view('answer.edit', compact('answer'));
    }

    /**
     * Update the specified answer in storage.
     *
     * @param  int      $id
     * @param  Request  $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $answer = $this->answer->find($id);
        if (!$answer) {
            return redirect()->back()->with('error', 'Answer not found.');
        }

        if (!$answer->update($request->all())) {
            return redirect()->back()->with('error', 'Problem editing Answer.');
        }

        return redirect()->back()->with('success', 'Answer successfully updated!');
    }

    /**
     * Remove the specified answer from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!$this->answer->delete($id)) {
            return redirect()->back()->with('error', 'Problem deleting Answer.');
        }

        return redirect()->back()->with('success', 'Answer successfully deleted!');
    }
}
