<?php

namespace Modules\Store\Entities;

use Baum\Node;
use Laracasts\Presenter\PresentableTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Presenters\CategoryPresenter;
use Modules\Store\Traits\TranslatableHelper;

class Category extends Node
{
    use TranslatableHelper, MediaRelation, PresentableTrait;

    protected $table = 'store__categories';
    public $translatedAttributes = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'og_type'];
    protected $fillable = ['title', 'slug', 'description', 'ordering', 'status', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'og_type', 'sitemap_include', 'sitemap_priority', 'sitemap_frequency', 'meta_robot_no_index', 'meta_robot_no_follow'];

    protected $presenter = CategoryPresenter::class;

    protected $casts = [
        'status' => 'int'
    ];

    protected $with = ['products'];

    protected $orderColumn = 'ordering';

    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'store__product_categories');
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::PUBLISHED);
    }

    public function getUrlAttribute()
    {
        return route('store.category.slug', [$this->slug]);
    }
}
