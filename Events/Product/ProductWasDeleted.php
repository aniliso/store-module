<?php

namespace Modules\Store\Events\Product;

use Modules\Media\Contracts\DeletingMedia;

class ProductWasDeleted implements DeletingMedia
{
    private $productId;
    private $productClass;

    /**
     * ProductWasDeleted constructor.
     * @param $productId
     * @param $productClass
     */
    public function __construct($productId, $productClass)
    {

        $this->productId = $productId;
        $this->productClass = $productClass;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->productId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->productClass;
    }
}
