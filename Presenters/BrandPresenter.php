<?php namespace Modules\Store\Presenters;


class BrandPresenter extends BaseStorePresenter
{
    protected $zone     = 'brandImage';
    protected $slug     = 'uri';
    protected $transKey = 'store::routes.brand.slug';
    protected $routeKey = 'store.brand.slug';
}