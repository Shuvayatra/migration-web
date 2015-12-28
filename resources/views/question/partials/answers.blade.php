@if(old('question'))
    @if(!is_array($answer))
        <?php $answerService = app('App\Nrna\Services\AnswerService'); ?>
        <div class="form-group">
            <label for="answer" class="col-sm-3 control-label"></label>
            <?php
            $question = $answer;
            ?>
            <div class="col-sm-6">
                <?php $questionObj = $questionService->find($question);?>
                <span><strong>Q. {{$questionObj->metadata->title}}</strong></span>
                <input name="question[]" value="{{$question}}" type="hidden">

                <div class="question-answers">
                    @foreach($questionObj->answers as $answer)
                        <div class="checkbox">
                            <label><input @if(isset($questions[$question]) && in_array($answer->id,array_keys($questions[$question]['answer'])) )
                                    checked @endif type="checkbox"
                                    name="question[{{$question}}][answer][{{$answer->id}}]">
                                {{$answer->title}}
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="delete delete-answer-field btn btn-danger">X</div>
        </div>
    @endif
@else
    <div class="form-group">
        <label for="answer" class="col-sm-3 control-label"></label>

        <div class="col-sm-6">
            <span><strong>Q. {{$question->metadata->title}}</strong></span>
            <input name="question[]" value="{{$question->id}}" type="hidden">

            <div class="question-answers">
                @foreach($question->answers as $answer)
                    <div class="checkbox">
                        <label><input @if(isset($post) && in_array($answer->id,$post->answers->lists('id')->toArray()))
                                checked @endif  type="checkbox"
                                name="question[{{$question->id}}][answer][{{$answer->id}}]">{{$answer->title}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="delete delete-answer-field btn btn-danger">X</div>
    </div>
@endif


