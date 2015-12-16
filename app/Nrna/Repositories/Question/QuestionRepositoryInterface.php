<?php
namespace App\Nrna\Repositories\Question;


/**
 * Class QuestionRepositoryInterface
 * @package App\Nrna\Repository\Question
 */
interface QuestionRepositoryInterface
{

    /**
     * Save Question
     * @param $data
     * @return Question
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Question
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
     * @return array
     */
    public function lists();

    /**
     * @param $filter
     * @return Collection
     */
    public function latest($filter);
}