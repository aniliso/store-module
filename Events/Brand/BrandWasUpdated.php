<?php namespace Modules\Store\Events\Brand;

use Modules\Media\Contracts\StoringMedia;
use Modules\Store\Entities\Brand;

class BrandWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var Brand
     */
    private $brand;

    /**
     * ProductWasUpdated constructor.
     * @param Product $product
     * @param array $data
     */
    public function __construct(Brand $brand, array $data)
    {
        $this->data = $data;
        $this->brand = $brand;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->brand;
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
