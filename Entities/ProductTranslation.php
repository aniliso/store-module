<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_type', 'technical_description'];
    protected $table = 'store__product_translations';
}
