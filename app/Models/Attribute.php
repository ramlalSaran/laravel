<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','name_key','is_variant','status',
    ];

    public function attributeValues(){
        
        return $this->hasMany(Attributevalue::class);
    }
}
