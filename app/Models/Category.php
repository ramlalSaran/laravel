<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable=[
        
        'parent_category','name','status','show_in_menu','url_key','meta_tag','meta_title','meta_description','short_description','description',
        
    ];
    public function products(){
        return $this->belongsToMany(Product::class , 'product_categories');
    } 
}