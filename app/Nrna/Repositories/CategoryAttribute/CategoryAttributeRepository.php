<?php
namespace App\Nrna\Repositories\CategoryAttribute;

use App\Nrna\Models\CategoryAttribute;

/**
 * Class CategoryAttributeRepository
 * @package App\Nrna\Repository\CategoryAttribute
 */
class CategoryAttributeRepository implements CategoryAttributeRepositoryInterface
{
    /**
     * @var CategoryAttribute
     */
    private $category;

    /**
     * constructor
     * @param CategoryAttribute $category
     */
    public function __construct(CategoryAttribute $category)
    {
        $this->category = $category;
    }

    /**
     * Save CategoryAttribute
     * @param $data
     * @return CategoryAttribute
     */
    public function save($data)
    {
        return $this->category->create($data);
    }

    /**
     * @param       $section_id
     * @param array $filter
     * @param  null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($section_id, $filter = [], $limit = null)
    {
        $query = $this->category->sorted()->where('section_id', $section_id);
        if (!empty($filter)) {
            $query->where('parent_id', $filter['category']);
        }
        if (is_null($limit)) {
            return $query->get();
        }

        return $query->paginate();
    }

    /**
     * @param $id
     * @return CategoryAttribute
     */
    public function find($id)
    {
        return $this->category->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->category->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->category->destroy($id);
    }

    /**
     * get list of category with title and id
     *
     * @return array
     */

    public function lists()
    {
        return $this->category->lists('title', 'id');
    }

    /**
     * get latest category
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->category->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted categorys
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->category->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
