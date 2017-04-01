<?php namespace Modules\Store\Events\Product;

use Modules\Media\Contracts\StoringMedia;

class ProductWasCreated implements StoringMedia
{
    /**
     * @var
     */
    private $product;
    /**
     * @var array
     */
    private $data;

    public function __construct($product, array $data)
    {
        //
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
