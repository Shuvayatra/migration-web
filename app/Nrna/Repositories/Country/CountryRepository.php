<?php
namespace App\Nrna\Repositories\Country;

use App\Nrna\Models\Country;

/**
 * Class CountryRepository
 * @package App\Nrna\Repository\Country
 */
class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @var Country
     */
    private $country;

    /**
     * constructor
     * @param Country $country
     */
    function __construct(Country $country)
    {
        $this->country = $country;
    }


    /**
     * Save Country
     * @param $data
     * @return Country
     */
    public function save($data)
    {
        return $this->country->create($data);
    }

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit)
    {
        if (is_null($limit)) {
            return $this->country->all();
        }

        return $this->country->paginate();
    }

    /**
     * @param $id
     * @return Country
     */
    public function find($id)
    {
        return $this->country->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->country->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->country->destroy($id);
    }
}