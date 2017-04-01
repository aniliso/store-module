<?php

namespace Modules\Store\Repositories\Cache;

use Modules\Store\Repositories\BrandRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBrandDecorator extends BaseCacheDecorator implements BrandRepository
{
    public function __construct(BrandRepository $brand)
    {
        parent::__construct();
        $this->entityName = 'store.brands';
        $this->repository = $brand;
    }
}
