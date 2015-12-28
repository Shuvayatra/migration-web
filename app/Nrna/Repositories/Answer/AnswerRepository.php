<?php
namespace App\Nrna\Repositories\Answer;

use App\Nrna\Models\Answer;

/**
 * Class AnswerRepository
 * @package App\Nrna\Repository\Answer
 */
class AnswerRepository implements AnswerRepositoryInterface
{
    /**
     * @var Answer
     */
    private $answer;

    /**
     * constructor
     * @param Answer $answer
     */
    function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }


    /**
     * Save Answer
     * @param $data
     * @return Answer
     */
    public function save($data)
    {
        return $this->answer->create($data);
    }

    /**
     * @param null $limit
     * @return Collection
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->answer->all();
        }

        return $this->answer->paginate();
    }

    /**
     * @param $id
     * @return Answer
     */
    public function find($id)
    {
        return $this->answer->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->answer->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->answer->destroy($id);
    }

    /**
     * get latest answer
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->answer->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

}