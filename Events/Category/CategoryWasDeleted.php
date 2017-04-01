<?php namespace Modules\Store\Events\Category;

use Modules\Media\Contracts\DeletingMedia;

class CategoryWasDeleted implements DeletingMedia
{
    /**
     * @var
     */
    private $categoryId;
    /**
     * @var
     */
    private $categoryClass;

    /**
     * CategoryWasDeleted constructor.
     * @param $categoryId
     * @param $categoryClass
     */
    public function __construct($categoryId, $categoryClass)
    {
        //
        $this->categoryId = $categoryId;
        $this->categoryClass = $categoryClass;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->categoryId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->categoryClass;
    }
}
