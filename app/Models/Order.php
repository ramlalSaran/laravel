<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_increament_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'pincode',
        'coupon',
        'coupon_discount',
        'total',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'sub_total',
    ];


    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
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
    

}
