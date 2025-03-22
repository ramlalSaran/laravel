<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Order;
use App\Models\Quote;
use App\Models\OrderItem;
use App\Models\QuoteItem;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class CheckoutController extends Controller
{
    public function CheckoutForm(Request $request)
    {
        if (Auth::check()) 
        {
            $cartId = session('cart_id');

            $quotedata = Quote::where('cart_id', $cartId)->first();

            // Check if quote data is empty
            if (!$quotedata) 
            {
                return redirect()->route('cartShow');
            }
    
            $checkItems = QuoteItem::with('product')->where('quote_id', $quotedata->id)->get();
            
            // check product out of stock 
            foreach ($checkItems as  $check) {
                if ($check->product->stock_status <= 0) {
                   return back()->with('Outstock','Product out of stock '.$check->product->name);
                }
            }

            // Check if checkItems is empty
            if ($checkItems->isEmpty()) 
            {
                return redirect()->route('cartShow')->with('error', 'Cart is empty');
            }
            // Fetch saved addresses
            $savedAddresses = OrderAddress::where('user_id', Auth::user()->id)->get();
            // dd($savedAddresses);
            return view('e-commerce.checkout.checkout', compact('checkItems', 'quotedata', 'savedAddresses'));
        } else {
            return redirect()->route('login_form')->with('error', 'Please log in first');
        }  
    }

    public function shipping_cost(Request $request)
    {
        $shippingCost = $request->input('shipping_cost');
        $quoteId      = $request->input('quote_id');

        $quote = Quote::where('id',$quoteId)->first();
        $total = $quote->total + $shippingCost;
        // dd($total);
       return  response([
            'shipping_cost' => $shippingCost,
            'total'         => $total,
        ]);
    }
}