<?php

namespace Modules\Store\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Presenters\ProductPresenter;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;

class Product extends Model implements TaggableInterface
{
    use Translatable, MediaRelation, PresentableTrait, TaggableTrait, NamespacedEntity;

    protected $table = 'store__products';
    public $translatedAttributes = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_type', 'technical_description'];
    protected $fillable = ['title', 'slug', 'description', 'status', 'sku', 'model', 'price', 'ordering', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_type', 'sitemap_frequency', 'sitemap_priority', 'sitemap_include', 'meta_robot_no_index', 'meta_robot_no_follow', 'is_new', 'video', 'technical_description', 'settings'];
    public $timestamps = true;

    protected static $entityNamespace = 'asgardcms/store';

    protected $presenter = ProductPresenter::class;

    protected $casts = [
        'status'   => 'int',
        'is_new'   => 'int',
        'settings' => 'object'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'store__product_categories')->with(['translations']);
    }

    public function related()
    {
        return $this->belongsToMany(Product::class, 'store__related_products', 'related_id')->active();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id')->with('translations');
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::PUBLISHED);
    }

    public function getUrlAttribute()
    {
        return localize_trans_url(locale(), 'store::routes.product.slug', ['id'=>$this->id, 'uri'=>$this->slug]);
    }

    public function hasImage()
    {
        return $this->files()->exists() ? true : false;
    }

    public function getRobotsAttribute()
    {
        return $this->meta_robot_no_index . ', ' . $this->meta_robot_no_follow;
    }

    public function scopeCategorized($query, Category $category = null)
    {
        if (is_null($category)) return $query->with('categories');
        $categoryIds = $category->getDescendantsAndSelf()->pluck('id');
        return $query->with('categories')
            ->join('store__product_categories', 'store__product_categories.product_id', '=', 'store__products.id')
            ->whereIn('store__product_categories.category_id', $categoryIds);
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword != '') {
            $query->whereHas('translations', function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%");
            });
        }
        return $query;
    }

    public function scopeHasSlug($query, $slug)
    {
        return $query->whereHas('translations', function ($query) use ($slug) {
            $query->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'");
        })->with('translations')->count();
    }

    private static function generateSlug($slug)
    {

        $slugs = Product::whereHas('translations', function ($query) use ($slug) {
            $query->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'");
        })->with('translations');

        if ($slugs->count() === 0) {
            return $slug;
        }

        // Increment/append the counter and return the slug we generated
        return $slug . '-' . ($slugs->count() + 1);
    }

    public function scopeMatch($query, $value)
    {
        return $query->whereHas('translations', function (Builder $q) use ($value) {
            $q->where("title", "like", "%".$value."%");
            $q->orWhere("description", "like", "%".$value."%");
        })->orWhere("model", "like", "%".$value."%")
            ->orWhere("sku", "like", "%".$value."%")
            ->with(['translations'])->whereStatus(Status::PUBLISHED);
    }

    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $term = preg_replace('/[^\p{L}\p{N}_]+/u', ' ', $term);
        $words = explode(' ', $term);
        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }
}
