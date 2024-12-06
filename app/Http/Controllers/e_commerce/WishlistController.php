<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlistindex()
    {
        $uId = Auth::user()->id;
        $wishListItems = Wishlist::with('product')->where('user_id',$uId)->get();
        // dd($wishListItems);
        return view('e-commerce.wishlist.index',compact('wishListItems'));
    }
    public function wishlistPost(string $id)
    {
        $uId = Auth::user()->id;
        // dd($uId);
        $insert = Wishlist::create([
                'product_id'=>$id,
                'user_id'=>$uId
        ]);
        if ($insert) 
        {
            return redirect()->route('wishlist')->with('success','add wishlist product successFully');
        }
    }
    public function wishlistDelete(string $id)
    {
        Wishlist::where('product_id',$id)->delete();
        return redirect()->route('wishlist')->with('success','Product deleted to Your Wishlist');
    }
}
