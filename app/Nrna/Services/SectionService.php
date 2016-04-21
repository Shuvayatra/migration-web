<?php
namespace App\Nrna\Services;

use App\Nrna\Models\CategoryAttribute;
use App\Nrna\Models\Section;
use App\Nrna\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface;
use App\Nrna\Repositories\Section\SectionRepositoryInterface;
use Exception;

/**
 * ClassSectionService
 * @package App\Nrna\Services
 */
class SectionService
{
    /**
     * @var SectionRepositoryInterface
     */
    protected $section;
    /**
     * @var CategoryAttributeRepositoryInterface
     */
    private $category;

    /**
     * constructor
     * @param SectionRepositoryInterface           $section
     * @param CategoryAttributeRepositoryInterface $category
     */
    public function __construct(
        SectionRepositoryInterface $section,
        CategoryAttributeRepositoryInterface $category
    ) {
        $this->section  = $section;
        $this->category = $category;
    }

    /**
     * @param $formData
     * @return Section|bool
     */
    public function save($formData)
    {
        try {
            $section = $this->section->save($formData);

            return $section;
        } catch (Exception $e) {

            return false;
        }

        return false;
    }

    /**
     * @param  int $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->section->getAll($limit);
    }

    /**
     * @param $id
     * @return Section
     */
    public function find($id)
    {
        try {
            return $this->section->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $section = $this->find($id);
        try {
            $section->update($formData);

            return true;
        } catch (Exception $e) {

            return false;
        }

        return;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->section->delete($id);
    }


    /**
     * @return array
     */
    public function getList()
    {
        return $this->section->getAll()->lists('title', 'id');
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $sectionArray = [];
        $sections     = $this->section->latest($filter);
        foreach ($sections as $section) {
            $sectionArray[] = $this->buildSection($section);
        }

        return $sectionArray;
    }

    /**
     * @param Section $section
     * @return mixed
     */
    public function buildSection(Section $section)
    {
        $sectionArray['id']         = $section->id;
        $sectionArray['title']      = $section->title;
        $sectionArray['alias_name'] = $section->section;
        $sectionArray['category']   = [];
        foreach ($section->categories as $category) {
            $sectionArray['category'] [] = $this->buildCategories($category);
        }
        $sectionArray['sub_category'] = [];
        foreach ($section->subCategories as $subcategory) {
            $sectionArray['sub_category'] [] = $this->buildSubCategories($subcategory);
        }

        $sectionArray['created_at'] = $section->created_at->timestamp;
        $sectionArray['updated_at'] = $section->updated_at->timestamp;

        return $sectionArray;
    }

    /**
     * @param CategoryAttribute $category
     * @return array
     */
    public function buildCategories(CategoryAttribute $category)
    {
        $categoryArray['id']          = $category->id;
        $categoryArray['title']       = $category->title;
        $categoryArray['position']    = $category->position;
        $categoryArray['description'] = $category->description;
        $categoryArray['main_image']  = $category->main_image_link;
        $categoryArray['icon']        = $category->icon_link;
        $categoryArray['small_icon']  = $category->small_icon_link;
        $categoryArray['created_at']  = $category->created_at->timestamp;
        $categoryArray['updated_at']  = $category->updated_at->timestamp;

        return $categoryArray;
    }

    /**
     * @param CategoryAttribute $category
     * @return array
     */
    public function buildSubCategories(CategoryAttribute $category)
    {
        $categoryArray['id']         = $category->id;
        $categoryArray['title']      = $category->title;
        $categoryArray['parent']     = $category->parent_id;
        $categoryArray['position']   = $category->position;
        $categoryArray['created_at'] = $category->created_at->timestamp;
        $categoryArray['updated_at'] = $category->updated_at->timestamp;

        return $categoryArray;
    }

    /**
     * gets deleted posts
     * @param $filter
     * @return array
     */
    public function deleted($filter)
    {
        $section['section']  = $this->section->deleted($filter);
        $section['category'] = $this->category->deleted($filter);

        return $section;
    }
}
