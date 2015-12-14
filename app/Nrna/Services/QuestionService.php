<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Question;
use App\Nrna\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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
     * constructor
     * @param QuestionRepositoryInterface $question
     * @param TagService                  $tag
     * @param DatabaseManager             $database
     */
    function __construct(QuestionRepositoryInterface $question, TagService $tag, DatabaseManager $database)
    {
        $this->question = $question;
        $this->tag      = $tag;
        $this->database = $database;
    }

    /**
     * @param $formData
     * @return Question|bool
     */
    public function save($formData)
    {
        $this->database->beginTransaction();
        try {
            if ($question = $this->question->save($formData)) {
                $tags = $this->tag->createOrGet($formData['tag']);
                $question->tags()->sync($tags);
                $this->database->commit();

                return $question;
            }
        } catch (\Exception $e) {
            $this->database->rollback();

            return false;
        }
        $this->database->rollback();

        return false;
    }


    /**
     * @param int $limit
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
        $this->database->beginTransaction();
        try {
            $question = $this->find($id);
            if ($question->update($formData)) {
                $tags = $this->tag->createOrGet($formData['tag']);
                $question->tags()->sync($tags);
                $this->database->commit();

                return $question;
            }
        } catch (\Exception $e) {
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
     * @return array
     */
    public function latest()
    {
        $questionArray = [];
        $questions     = $this->question->latest();
        foreach ($questions as $question) {
            $questionArray[] = $this->buildQuestion($question);
        }

        return $questionArray;
    }

    /**
     * @param Question $question
     * @return array
     */
    public function buildQuestion(Question $question)
    {
        $questionArray['id']         = $question->id;
        $questionArray['created_at'] = $question->created_at->timestamp;
        $questionArray['updated_at'] = $question->updated_at->timestamp;
        $tags                        = [];
        foreach ($question->tags as $tag) {
            $tags[] = $tag->title;
        }
        $questionArray['tags'] = $tags;

        return array_merge($questionArray, (array) $question->metadata);
    }

}