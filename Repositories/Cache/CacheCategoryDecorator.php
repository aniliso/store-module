<?php

namespace Modules\Store\Repositories\Cache;

use Modules\Store\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'store.categories';
        $this->repository = $category;
    }

    public function lists($except='')
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.lists.{$except}", $this->cacheTime,
                function () use ($except) {
                    return $this->repository->lists($except);
                }
            );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findLocalesById($id)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.findLocalesById.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->findLocalesById($id);
                }
            );
    }

    public function roots()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.roots", $this->cacheTime,
                function () {
                    return $this->repository->roots();
                }
            );
    }
}
