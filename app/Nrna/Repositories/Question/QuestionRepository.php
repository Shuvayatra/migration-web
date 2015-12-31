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
    public function __construct(Question $question)
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
     * @param  null                                              $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->question->orderBy('id', 'DESC')->all();
        }

        return $this->question->orderBy('id', 'DESC')->paginate();
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
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->question->with('tags')->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * find in query with key and value eg [id=>[1,2]]
     *
     * @param  array      $criteria
     * @return Collection
     */
    public function findByKey($criteria)
    {
        $key    = key($criteria);
        $values = $criteria[$key];

        return $this->question->whereIn($key, $values)->get();
    }

    /**
     * gets deleted questions
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->question->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
