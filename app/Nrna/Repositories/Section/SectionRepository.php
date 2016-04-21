<?php
namespace App\Nrna\Repositories\Section;

use App\Nrna\Models\Section;

/**
 * Class SectionRepository
 * @package App\Nrna\Repository\Section
 */
class SectionRepository implements SectionRepositoryInterface
{
    /**
     * @var Section
     */
    private $section;

    /**
     * constructor
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * Save Section
     * @param $data
     * @return Section
     */
    public function save($data)
    {
        return $this->section->create($data);
    }

    /**
     * @param  null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->section->get();
        }

        return $this->section->paginate();
    }

    /**
     * @param $id
     * @return Section
     */
    public function find($id)
    {
        return $this->section->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->section->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->section->destroy($id);
    }

    /**
     * get list of section with title and id
     *
     * @return array
     */

    public function lists()
    {
        return $this->section->lists('title', 'id');
    }

    /**
     * get latest section
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->section->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted sections
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->section->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
