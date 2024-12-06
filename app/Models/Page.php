<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable=[
        'title','heading','description','ordering','status','url_key','show_in_menu','show_in_footer','meta_tag','meta_title','meta_description',
    ];
}
