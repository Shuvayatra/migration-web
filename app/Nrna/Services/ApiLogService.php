<?php namespace App\Nrna\Services;


use App\Nrna\Repositories\ApiLog\ApiLogRepositoryInterface;

class ApiLogService
{
    /**
     * @var ApiLogRepositoryInterface
     */
    protected $apiLog;

    /**
     * ApiLogService constructor.
     * @param ApiLogRepositoryInterface $apiLog
     */
    public function __construct(ApiLogRepositoryInterface $apiLog)
    {
        $this->apiLog = $apiLog;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->apiLog->getList();
    }

    /**
     * @param $logDetails
     * @return mixed
     */
    public function saveLog($logDetails)
    {
        return $this->apiLog->saveLog($logDetails);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->apiLog->find($id);
    }
}