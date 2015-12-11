<?php
namespace App\Nrna\Repositories\Question;

use App\Nrna\Models\Question;

/**
 * Class QuestionRepository
 * @package App\Nrna\Repository\Question
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var Question
     */
    private $question;

    /**
     * constructor
     * @param Question $question
     */
    function __construct(Question $question)
    {
        $this->question = $question;
    }


    /**
     * Save Question
     * @param $data
     * @return Question
     */
    public function save($data)
    {
        return $this->question->create($data);
    }

    /**
     * @param null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->question->all();
        }

        return $this->question->paginate();
    }

    /**
     * @param $id
     * @return Question
     */
    public function find($id)
    {
        return $this->question->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->question->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->question->destroy($id);
    }

    /**
     * get list of question with title and id
     *
     * @return array
     */
    public function lists()
    {
        return $this->question->selectRaw("id,metadata->>'title' as title")->lists('title', 'id');
    }

    /**
     * get latest question with tags
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest()
    {
        return $this->question->with('tags')->get();
    }
}