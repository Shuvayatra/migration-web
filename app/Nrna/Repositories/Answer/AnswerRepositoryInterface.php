<?php
namespace App\Nrna\Repositories\Answer;


/**
 * Class AnswerRepositoryInterface
 * @package App\Nrna\Repository\Answer
 */
interface AnswerRepositoryInterface
{

    /**
     * Save Answer
     * @param $data
     * @return Answer
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Answer
     */
    public function find($id);

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data);

    /**
     * @param $id
     * @return int
     */
    public function delete($id);

    /**
     * get latest answer
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter);
}