<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Review;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductDetailController extends Controller
{
    public function ProductDetailPage($url_key)
    {
     
        $productDetail = Product::with('productAttributes.attributeValue', 'productAttributes.attribute')->where('url_key', $url_key)->first();

        if ($productDetail->url_key == $url_key) {
            
       
        $relatedIds = explode(',', $productDetail->related_product);

        $relatedProducts = Product::whereIn('id', $relatedIds)->get();
        
        // dd($pId);
        $ProAttr = $productDetail->productAttributes()->get();
        
        $pId = $productDetail->id;
        // dd($pId);
        $reviews = Review::where('product_id',$productDetail->id)->orderBy('created_at','DESC')->take(2)->get();
        $avgRating = Review::where('product_id',$productDetail->id)->avg('rating');
        // dd($avgRating);
        //    dd($reviews);
        return view('e-commerce.productDetail.productDetailPage',compact('productDetail','relatedProducts','ProAttr','reviews','avgRating'));
    }else{
        return view('admin.pagenotfound.404');
    }
    }
}
