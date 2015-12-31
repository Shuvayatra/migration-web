<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Answer;
use App\Nrna\Repositories\Answer\AnswerRepositoryInterface;

/**
 * Class AnswerService
 * @package App\Nrna\Services
 */
class AnswerService
{
    /**
     * @var AnswerRepositoryInterface
     */
    private $answer;

    /**
     * constructor
     * @param AnswerRepositoryInterface $answer
     */
    public function __construct(AnswerRepositoryInterface $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @param $data
     * @return Answer
     */
    public function save($data)
    {
        return $this->answer->save($data);
    }

    /**
     * @param  int                                      $limit
     * @return \App\Nrna\Repositories\Answer\Collection
     */
    public function all($limit = 15)
    {
        return $this->answer->getAll($limit);
    }

    /**
     * @param $id
     * @return Answer
     */
    public function find($id)
    {
        try {
            return $this->answer->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->answer->delete($id);
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $answerArray = [];
        $answers     = $this->answer->latest($filter);
        foreach ($answers as $answer) {
            $answerArray[] = $this->buildAnswer($answer);
        }

        return $answerArray;
    }

    /**
     * answer response format for api
     * @param  Answer $answer
     * @return array
     */
    public function buildAnswer(Answer $answer)
    {
        $answerArray['id']          = $answer->id;
        $answerArray['title']       = $answer->title;
        $answerArray['question_id'] = $answer->question_id;
        $answerArray['created_at']  = $answer->created_at->timestamp;
        $answerArray['updated_at']  = $answer->updated_at->timestamp;

        return $answerArray;
    }

    /**
     * gets deleted answers
     * @param $filter
     * @return array
     */
    public function deleted($filter)
    {
        $posts = $this->answer->deleted($filter);

        return $posts;
    }
}
