<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Page;
use App\Models\User;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $sliders=Slider::where('status',1)->orderBy('ordering','asc')->get();
        $user = User::where('is_admin' , 1)->first();
        $reviews = Review::with('product')->get();
        // dd($reviews);
        
        return view('e-commerce.index',compact('sliders','user','reviews',));
    }
   
    public function page($url_key)
    {
        $Page=Page::where('url_key',$url_key)->where('status',1)->first();
        return view('e-commerce.page',compact('Page'));
    }

    public function CategotyPage($url_key)
    {
        $category = Category::where('url_key',$url_key)->with('products')->first();
        return view('e-commerce.categories.categorPage',compact('category'));
    }
}
