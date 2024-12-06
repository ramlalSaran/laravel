<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'name', 'sku',
        'price', 'qty', 'row_total', 'coustom_option',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attributevalue_id');
    }
    // function attributeValues(){

    // }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
