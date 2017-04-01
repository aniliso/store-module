<?php namespace Modules\Store\Events\Product;

use Modules\Media\Contracts\StoringMedia;
use Modules\Store\Entities\Product;

class ProductWasUpdated implements StoringMedia
{
    /**
     * @var Product
     */
    private $product;
    /**
     * @var array
     */
    private $data;

    /**
     * ProductWasUpdated constructor.
     * @param Product $product
     * @param array $data
     */
    public function __construct(Product $product, array $data)
    {
        $this->product = $product;
        $this->data = $data;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->product;
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
