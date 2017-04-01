<?php namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    public $timestamps = false;
    protected $table = 'store__product_categories';
    protected $fillable = ['product_id', 'category_id'];
}