<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteItem extends Model
{
    use HasFactory;
    protected $fillable= [
        'quote_id','product_id','name','sku','price','qty','row_total','coustom_option'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
