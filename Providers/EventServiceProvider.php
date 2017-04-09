<?php namespace Modules\Store\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Media\Events\Handlers\HandleMediaStorage;
use Modules\Media\Events\Handlers\RemovePolymorphicLink;
use Modules\Store\Events\Brand\BrandWasCreated;
use Modules\Store\Events\Brand\BrandWasDeleted;
use Modules\Store\Events\Brand\BrandWasUpdated;
use Modules\Store\Events\Category\CategoryWasCreated;
use Modules\Store\Events\Category\CategoryWasDeleted;
use Modules\Store\Events\Category\CategoryWasUpdated;
use Modules\Store\Events\Product\ProductWasCreated;
use Modules\Store\Events\Product\ProductWasDeleted;
use Modules\Store\Events\Product\ProductWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
      ProductWasCreated::class => [
          HandleMediaStorage::class
      ],
      ProductWasUpdated::class => [
          HandleMediaStorage::class
      ],
      ProductWasDeleted::class => [
          RemovePolymorphicLink::class
      ],
      CategoryWasCreated::class => [
          HandleMediaStorage::class
      ],
      CategoryWasUpdated::class => [
          HandleMediaStorage::class
      ],
      CategoryWasDeleted::class => [
          RemovePolymorphicLink::class
      ],
      BrandWasCreated::class => [
          HandleMediaStorage::class
      ],
      BrandWasUpdated::class => [
          HandleMediaStorage::class
      ],
      BrandWasDeleted::class => [
          RemovePolymorphicLink::class
      ]
    ];
}