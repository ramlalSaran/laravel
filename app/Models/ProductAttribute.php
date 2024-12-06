<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    public $fillable=[
        'product_id','attribute_id','attributevalue_id',
    ];
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attributevalue_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
