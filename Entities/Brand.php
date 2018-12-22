<?php

namespace Modules\Store\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Blog\Entities\Status;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Store\Presenters\BrandPresenter;

class Brand extends Model
{
    use Translatable, MediaRelation, PresentableTrait;

    protected $table = 'store__brands';
    public $translatedAttributes = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'og_type'];
    protected $fillable = ['title', 'slug', 'description', 'ordering', 'status', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'og_type', 'sitemap_include', 'sitemap_priority', 'sitemap_frequency', 'meta_robot_no_index', 'meta_robot_no_follow'];

    protected $presenter = BrandPresenter::class;

    protected $casts = [
        'status' => 'int'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::PUBLISHED);
    }

    public function getUrlAttribute()
    {
        return route('store.brand.slug', $this->slug);
    }
}
