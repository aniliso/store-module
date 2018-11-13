<?php namespace Modules\Store\Presenters;

use Embed\Embed;
use Embed\Utils;

class ProductPresenter extends BaseStorePresenter
{
    protected $zone     = 'productImages';
    protected $slug     = 'uri';
    protected $transKey = 'store::routes.product.slug';
    protected $routeKey = 'store.product.slug';
    protected $category;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->category = $this->entity->categories()->latest()->first();
    }

    public function file()
    {
        if($file = $this->entity->files()->where('zone', 'productFiles')->first()) {
            return $file->path;
        }
        return '';
    }

    public function titleWithBrand()
    {
        return $this->entity->brand->title . ' ' . $this->entity->title;
    }

    public function category_title()
    {
        return isset($this->category) ? $this->category->title : null;
    }

    public function category_url()
    {
        return isset($this->category) ? $this->category->url : null;
    }

    public function video($width, $height)
    {
        if(isset($this->entity->video) && ! empty($this->entity->video))
        {
            $info = Embed::create($this->entity->video);
            $providers = $info->getProviders();
            $oembed = $providers['html'];
            return Utils::iframe($oembed->get('twitter:player'), $width, $height);
        }
        return null;
    }

    public function isNew()
    {
        return $this->entity->is_new == 1 ? trans('store::products.title.new') : null;
    }

    public function url($locale='')
    {
        if(!empty($locale)) {
            if($this->entity->hasTranslation($locale)) {
                if(isset($this->entity->translate($locale)->{$this->slugKey})) {
                    return \LaravelLocalization::getURLFromRouteNameTranslated($locale, $this->transKey, ['id'=>$this->id, $this->slug => $this->entity->translate($locale)->{$this->slugKey}]);
                } else {
                    return \LaravelLocalization::getURLFromRouteNameTranslated($locale, $this->transKey, ['id'=>$this->id, $this->slug => $this->entity->{$this->slugKey}]);
                }
            }
        }
        return route($this->routeKey, $this->entity->{$this->slugKey});
    }
}