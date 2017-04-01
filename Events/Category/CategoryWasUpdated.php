<?php namespace Modules\Store\Events\Category;

use Modules\Media\Contracts\StoringMedia;
use Modules\Store\Entities\Category;

class CategoryWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoryWasUpdated constructor.
     * @param Category $category
     * @param array $data
     */
    public function __construct(Category $category, array $data)
    {
        $this->data = $data;
        $this->category = $category;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->category;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
