<?php namespace App\Nrna\Repositories\ApiLog;

interface ApiLogRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getList();

    /**
     * @param $logDetails
     * @return mixed
     */
    public function saveLog($logDetails);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);
}