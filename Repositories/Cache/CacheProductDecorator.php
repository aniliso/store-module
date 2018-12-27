<?php

namespace Modules\Store\Repositories\Cache;

use Modules\Store\Repositories\ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
    /**
     * CacheProductDecorator constructor.
     * @param ProductRepository $product
     */
    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->entityName = 'store.products';
        $this->repository = $product;
    }

    /**
     * @param $lang
     * @param $per_page
     * @return mixed
     */
    public function allTranslatedInPaginate($lang, $per_page)
    {
        $page = \Request::has('page') ? \Request::query('page') : 1;
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.allTranslatedInPaginate.{$lang}.{$per_page}.{$page}", $this->cacheTime,
                function () use ($lang, $per_page) {
                    return $this->repository->allTranslatedInPaginate($lang, $per_page);
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

    /**
     * @param int $amount
     * @return mixed
     */
    public function latest($amount = 5)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.latest.{$amount}", $this->cacheTime,
                function () use ($amount) {
                    return $this->repository->latest($amount);
                }
            );
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.query", $this->cacheTime,
                function () {
                    return $this->repository->query();
                }
            );
    }

    /**
     * @param $query
     * @param $per_page
     * @return mixed
     */
    public function search($query, $per_page)
    {
        $page = \Request::has('page') ? \Request::query('page') : 1;
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.search.{$query}.{$per_page}.{$page}", $this->cacheTime,
                function () use ($query, $per_page) {
                    return $this->repository->search($query, $per_page);
                }
            );
    }

    /**
     * @param int $amount
     * @return mixed
     */
    public function getNewProducts($amount = 5)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.getNewProducts.{$amount}", $this->cacheTime,
                function () use ($amount) {
                    return $this->repository->getNewProducts($amount);
                }
            );
    }
}
