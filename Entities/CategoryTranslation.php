<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'og_type'];
    protected $table = 'store__category_translations';
}
