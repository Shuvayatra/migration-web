<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Answer;
use App\Nrna\Models\Question;
use App\Nrna\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Contracts\Logging\Log;

/**
 * Class QuestionService
 * @package App\Nrna\Services
 */
class QuestionService
{
    /**
     * @var QuestionRepositoryInterface
     */
    private $question;
    /**
     * @var TagService
     */
    private $tag;
    /**
     * @var DatabaseManager
     */
    private $database;
    /**
     * @var Log
     */
    private $logger;

    /**
     * constructor
     * @param QuestionRepositoryInterface $question
     * @param TagService                  $tag
     * @param DatabaseManager             $database
     * @param Log                         $logger
     */
    public function __construct(QuestionRepositoryInterface $question, TagService $tag, DatabaseManager $database, Log $logger)
    {
        $this->question = $question;
        $this->tag      = $tag;
        $this->database = $database;
        $this->logger   = $logger;
    }

    /**
     * @param $formData
     * @return Question|bool
     */
    public function save($formData)
    {
        $tags = [];
        if (isset($formData['tag'])) {
            $tags = $this->tag->createOrGet($formData['tag']);
        }
        $this->database->beginTransaction();
        try {
            $question = $this->question->save($formData);
            if (!$question) {
                return false;
            }

            $this->saveAnswers($formData, $question);

            $question->tags()->sync($tags);
            $this->database->commit();

            return $question;
        } catch (\Exception $e) {
            $this->logger->error($e);
            $this->database->rollback();

            return false;
        }
        $this->database->rollback();

        return false;
    }

    /**
     * @param  int        $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->question->getAll($limit);
    }

    /**
     * @param $id
     * @return Question
     */
    public function find($id)
    {
        try {
            return $this->question->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $tags = [];
        if (isset($formData['tag'])) {
            $tags = $this->tag->createOrGet($formData['tag']);
        }
        $this->database->beginTransaction();
        try {
            $question = $this->find($id);
            if (!$question->update($formData)) {
                return false;
            }

            $question->tags()->sync($tags);
            $this->saveAnswers($formData, $question);
            $this->database->commit();

            return $question;
        } catch (\Exception $e) {
            dd($e);
            $this->database->rollback();

            return false;
        }
        $this->database->rollback();

        return false;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->question->delete($id);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->question->lists();
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $questionArray = [];
        $questions     = $this->question->latest($filter);
        foreach ($questions as $question) {
            $questionArray[] = $this->buildQuestion($question);
        }

        return $questionArray;
    }

    /**
     * question format for api
     * @param  Question $question
     * @return array
     */
    public function buildQuestion(Question $question)
    {
        $questionArray['id']         = $question->id;
        $questionArray               = array_merge($questionArray, (array) $question->metadata);
        $questionArray['tags']       = $question->tags->lists('id')->toArray();
        $questionArray['created_at'] = $question->created_at->timestamp;
        $questionArray['updated_at'] = $question->updated_at->timestamp;

        return $questionArray;
    }

    /**
     * save answers
     * @param $formData
     * @param $question
     */
    protected function saveAnswers($formData, $question)
    {
        if (isset($formData['answer'])) {
            $answers = [];
            foreach ($formData['answer'] as $answer) {
                $answers [] = new Answer($answer);
            }
            $question->answers()->saveMany($answers);
        }
    }

    /**
     * find question by answers ids
     * @param $ids
     * @return Collection
     */
    public function findByIds($ids)
    {
        return $this->question->findByKey(['id' => $ids]);
    }

    /**
     * gets deleted questions
     * @param $filter
     * @return array
     */
    public function deleted($filter)
    {
        $posts = $this->question->deleted($filter);

        return $posts;
    }
}
