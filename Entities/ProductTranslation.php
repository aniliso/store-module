<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_type', 'technical_description'];
    protected $table = 'store__product_translations';

    protected $appends = ['url'];

    protected function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute()
    {
        return localize_trans_url($this->locale, 'store::routes.product.slug', ['id'=>$this->product->id, 'uri'=>$this->slug]);
    }
}
