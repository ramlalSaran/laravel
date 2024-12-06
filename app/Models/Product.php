<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'name','status','is_featured','sku','qty','stock_status','weight','price','special_price','special_price_from','special_price_to','short_description','description','related_product','url_key','meta_tag','meta_title','meta_description',
    ];

    public function relatedProduct()
    {
        return $this->hasMany(Product::class, 'id', 'related_product')
        ->whereRaw('FIND_IN_SET(id, related_product)');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attributevalue_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories');
    }
}
