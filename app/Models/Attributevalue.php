<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributevalue extends Model
{
    use HasFactory;
    protected $fillable=[
        'attribute_id','name','status',
    ];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
