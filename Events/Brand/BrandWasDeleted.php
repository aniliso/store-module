<?php namespace Modules\Store\Events\Brand;

use Modules\Media\Contracts\DeletingMedia;

class BrandWasDeleted implements DeletingMedia
{
    private $brandId;
    private $brandClass;

    /**
     * ProductWasDeleted constructor.
     * @param $productId
     * @param $productClass
     */
    public function __construct($brandId, $brandClass)
    {

        $this->brandId = $brandId;
        $this->brandClass = $brandClass;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->brandId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->brandClass;
    }
}
