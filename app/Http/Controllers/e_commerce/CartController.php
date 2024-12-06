<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Quote;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\QuoteItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   
    function cartShow()
    {
        // dd(Session('cart_id'));
        // check session cart id is set
        if (Session('cart_id'))
        {
            $cartId = Session('cart_id');
            // fetch data on the quote table only cart_id macth data show 
            $user_id = Auth::user()->id ?? '';
            $cartdata = Quote::where('cart_id', $cartId)->orwhere('user_id',$user_id)->first();
            if ($cartdata) 
            {
                $cart_items = QuoteItem::with('product')->where('quote_id', $cartdata->id)->get();
            } 
            else{ 
                $cart_items = collect();   
            }
            return view('e-commerce.Cart.cart', compact('cart_items','cartdata'));
        } 
        else{
            $cart_items = collect();
            $cart       = collect();
            $cartdata   = $cart->first() ?? null;
            return view('e-commerce.Cart.cart', compact('cart_items','cartdata'));
        }
    }

    function CartStore(Request $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : null;
    
        $cart_Id = Session('cart_id');
        // dd($cart_Id);
        
        if (!$cart_Id) {
            // Generate a random cart ID for the session if the user is not authenticated
            $cart_Id = Str::random(20);
            session(['cart_id' => $cart_Id]);
        }
    
        // For authenticated users, create or retrieve quote record
        if ($user_id) {
            // dd('dfbdfb');
            // Use user_id when logged in
            $create = Quote::where('cart_id', $cart_Id)->where('user_id', $user_id)->firstOrCreate([
                'cart_id' => $cart_Id, 
                'user_id' => $user_id, 
            ]);
        } else {
            $create = Quote::where('cart_id', $cart_Id)->firstOrCreate([
                'cart_id' => $cart_Id,
            ]);

        }
    
       
        $product = Product::find($request->product_id);
        $price = displayPrice($product, false);
    

        $attr_value = json_encode($request->attribute_value);
        $qty = $request->qty;
        $rowTotal = $price * $qty;
    
        // Add product to QuoteItem table
        $Items = QuoteItem::create([
            'quote_id'       => $create->id,
            'product_id'     => $product->id,
            'name'           => $product->name,
            'sku'            => $product->sku,
            'price'          => $price,
            'qty'            => $qty,
            'coustom_option' => $attr_value,
            'row_total'      => $rowTotal,
        ]);
    
        // Calculate the new subtotal and total for the quote
        $quote_items = QuoteItem::where('quote_id', $create->id)->get();
        $subTotal = 0;
        foreach ($quote_items as $quote_item) {
            $subTotal += $quote_item->row_total;
        }
    
        // Update the subtotal and total in the Quote table
        if ($subTotal) {
            $update = Quote::where('id', $create->id)->update([
                'subtotal' => $subTotal,
                'total'    => $subTotal,
            ]);
        }
    
        // Redirect with success or error message
        if ($Items) {
            // dd('fdf');
            if ($user_id) {
                // dd('dsvd');
                return redirect()->route('cartShow')->with('success', 'Product added to cart successfully!');
            } else {
                // dd('back');
                // If user is not logged in, show a message that product is added to the cart
                return redirect()->route('cartShow')->with('success', 'Product added to cart! Please log in to complete your purchase.');
            }
        } else {
// die('dvd');
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    function ItemDelete($id)
    {
        $data      = QuoteItem::findorFail($id);
        $qoute_id  = $data->quote_id;
        $row_total = $data->row_total;

        $cart = Quote::where('id',$qoute_id)->first();
        $afterSubtotal = $cart->subtotal - $row_total;

        // if user are any item delete to cart so qoute table to subtotal and total - to product row total or coupon and coupon discount remove    
        $update = [
            'subtotal'          => $afterSubtotal,
            'coupon'            => null,
            'coupon_discount'   => null,
            'total'             => $afterSubtotal,
        ];

        Quote::where('id',$qoute_id)->update($update);

        // after delete item remove to cart item
       $ItemDelete = QuoteItem::where('id',$id)->delete();
       
       if ($ItemDelete) {
            return redirect()->route('cartShow')->with('success','Item are Deleted');
        }else{
           return redirect()->route('cartShow')->with('error','Item are not Delete');

       }
    }

    function QtyUpdate(Request $request ,$id)
    {
        // dd($request->all());

        // user want to  update qty this code run  
        $request->validate([
            'qty' => 'not_in:0',
        ]);

        $QuoteItem = QuoteItem::where('id',$id)->first();
        $price = displayPrice($QuoteItem, false) ;

        $qty      = $request->qty;
        $rowTotal = $price * $qty;
        $update = [
            'qty'        => $request->qty,
            'row_total'  => $rowTotal,
        ];
            
        $ItemUpd = QuoteItem::where('id',$id)->update($update);

        
        $cart_id    = $QuoteItem->quote_id;
        $quote_item = QuoteItem::where('quote_id',$cart_id)->get();
        $subTotal   = 0;

        foreach($quote_item as $total)
        {
            $subTotal += $total->row_total;
        }
        // check subTotal 
        if ($subTotal) 
        {
            $update = Quote::where('id',$cart_id)->update([
                'subtotal' => $subTotal,
                'total'    => $subTotal,
            ]);
        }
        // quote update and coupon or coupon discount remove
        Quote::where('cart_id', session('cart_id'))->update([
            'subtotal'         => $subTotal,
            'coupon'           => null,
            'coupon_discount'  => null,
            'total'            => $subTotal,
        ]);

        if ($ItemUpd)
        {
            return redirect()->route('cartShow')->with('success','Qty Update');
        }
        else{
        return redirect()->route('cartShow')->with('error','Qty Not Update');
        }
    }
    
    public function couponDiscount(Request $request)
    {
        // dd($request->all());
        $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();
        if ($coupon !== Null) 
        {
            $cart = Quote::where('id',$request->cart_id)->first();
            if (!$cart) {
                return back()->with('error' , 'sorry Your cart is empty');
            }else{

            if($cart->coupon_code >= $coupon->id)
            {
                return redirect()->back()->with('error', 'coupon has alrady been used');
            }
            else{
                if ($coupon->valid_to > now()) 
                {
                    if($cart->subtotal > $coupon->discount_amount)
                    {
                        // dd($coupon->discount_amount);
                        $total = $cart->subtotal - $coupon->discount_amount;
                        $update = [
                            "total"           => $total,
                            "coupon"          => $coupon->coupon_code,
                            "coupon_discount" => $coupon->discount_amount
                        ];
                        Quote::where('id',$request->cart_id)->update($update);
                            // dd('coupon apply succesfully');
                        return redirect()->back()->with('success', 'Coupon apply succesfully');
                    }
                    else{
                        // dd('coupon not applicable');
                        return redirect()->back()->with('error', 'coupon not applicable because subtotal is low');
    
                    }    
                }
                else{
                    return back()->with('error','coupon has expired');
                }
            }
        }
        }
        else{
            return back()->with('error','Invalid coupon code');
        }
    }

    function removeCoupon($id)
    {
        // remove coupon from cart 
        $quoteItems = QuoteItem::where('quote_id',$id)->get();
        $subTotal = 0;
        foreach ($quoteItems as  $quoteItem) 
        {
            $subTotal += $quoteItem->row_total;
        }
        // dd($subTotal);
        $update = [
            'subtotal'         => $subTotal,
            'coupon'           => null,
            'coupon_discount'  => null,
            'total'            => $subTotal
        ];

       $qoute = Quote::where('id',$id)->update($update);
       if ($qoute) 
       {
            return redirect()->route('cartShow')->with('success','Coupon Cancel SuccessFully');
        }
        else{
           return redirect()->route('cartShow')->with('error','Coupon Not Cancel Try again');

       }
    }
}