<?php namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class RelatedProducts extends Model
{
    public $timestamps = false;
    protected $table = 'store__related_products';
    protected $fillable = ['product_id', 'related_id'];
}