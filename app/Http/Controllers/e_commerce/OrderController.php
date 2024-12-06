<?php

namespace App\Http\Controllers\e_commerce;

use Gate;
use App\Models\Order;
use App\Models\Quote;
use App\Models\Product;
use App\Mail\OrderEmail;
use App\Models\OrderItem;
use App\Models\QuoteItem;
use Illuminate\Support\Str;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    function orderPlace(Request $request)
    {
        // dd($request->all());
        if ($request->billing_address_id == null)
        {
            $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|email',
                'phone'         => 'required|string|max:15',
                'address'       => 'required|string|max:255',
                'address2'      => 'nullable|string|max:255',
                'city'          => 'required|string|max:100',
                'state'         => 'required|string|max:100',
                'country'       => 'required|string|max:100',
                'zip_code'      =>'required|string|max:10',
                'shipping_method'=> 'required',
                'payment'       => 'required|string',
                'shipping_cost' => 'required',

            ]);
        }

        if ($request->shipping_address_id === null)
        { 
            if ($request->shipping || $request->shipping_name) 
            {
                $request->validate([
                    'shipping_name'          => 'required|string|max:255',
                    'shipping_email'         => 'required|email',
                    'shipping_phone'         => 'required|string|max:15',
                    'shipping_address'       => 'required|string|max:255',
                    'shipping_address2'      => 'nullable|string|max:255',
                    'shipping_city'          => 'required|string|max:100',
                    'shipping_state'         => 'required|string|max:100',
                    'shipping_country'       => 'required|string|max:100',
                    'shipping_zip_code'      => 'required|string|max:10',
                    'shipping_method'        => 'required',
                    'shipping_cost'          => 'required',

                ]);
            }
        }

        $user_id   = Auth::user()->id;
        $lastOrder = Order::orderBy('order_increament_id', 'desc')->first();

        if ($lastOrder) 
        {
            $lastId = (int)Str::substr($lastOrder->order_increament_id, -6); 
            $orderIncrementId = Str::padLeft($lastId + 1, 6, '0');
        } 
        else{
            $orderIncrementId = '100000';
        }

        if ($request->shipping_address_id == null or $request->billing_address_id == null)
        {
            $createOrder = [
                'order_increament_id'  => $orderIncrementId,
                'user_id'              => $user_id,
                'name'                 => $request->name,
                'email'                => $request->email,
                'phone'                => $request->phone,
                'address'              => $request->address,
                'address_2'            => $request->address2,
                'city'                 => $request->city,
                'state'                => $request->state,
                'country'              => $request->country,
                'pincode'              => $request->zip_code,
                'coupon'               => $request->coupon,
                'coupon_discount'      => $request->coupon_discount,
                'shipping_cost'        => $request->shipping_cost,
                'sub_total'            => $request->sub_total,
                'total'                => $request->total,
                'payment_method'       => $request->payment,
                'shipping_method'      => $request->shipping_method            
            ];
        }
        else{
            // Fetch addresses using either billing or shipping address ID
            $saveAddresses = OrderAddress::where('id', $request->billing_address_id)->orWhere('id', $request->shipping_address_id)->first();
            // dd($saveAddresses);
            $createOrder = [
                'order_increament_id'  => $orderIncrementId,
                'user_id'              => $user_id,
                'name'                 => $saveAddresses->name,
                'email'                => $saveAddresses->email,
                'phone'                => $saveAddresses->phone,
                'address'              => $saveAddresses->address,
                'address_2'            => $saveAddresses->address_2,
                'city'                 => $saveAddresses->city,
                'state'                => $saveAddresses->state,
                'country'              => $saveAddresses->country,
                'pincode'              => $saveAddresses->pincode,
                'coupon'               => $request->coupon,
                'coupon_discount'      => $request->coupon_discount,
                'shipping_cost'        => $request->shipping_cost,
                'sub_total'            => $request->sub_total,
                'total'                => $request->total,
                'payment_method'       => $request->payment,
                'shipping_method'      => $request->shipping_method
                
            ];
            // dd($createOrder);
        }
        $order = Order::create($createOrder);
        $orderId = $order->id;   
        // Check the conditions for address creation
        if ($request->billing_address_id === null && $request->shipping_address_id === null) 
        {
                $billing = [
                    'order_id'      => $orderId,
                    'user_id'       => $user_id,
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'phone'         => $request->phone,
                    'address'       => $request->address,
                    'address_2'     => $request->address2,
                    'city'          => $request->city,
                    'state'         => $request->state,
                    'country'       => $request->country,
                    'pincode'       => $request->zip_code,
                    'address_type'  => 'billing_address',
                ];
                
                $shipping = [
                    'order_id'      => $orderId,
                    'user_id'       => $user_id,
                    'name'          => $request->shipping_name,
                    'email'         => $request->shipping_email,
                    'phone'         => $request->shipping_phone,
                    'address'       => $request->shipping_address,
                    'address_2'     => $request->shipping_address2,
                    'city'          => $request->shipping_city,
                    'state'         => $request->shipping_state,
                    'country'       => $request->shipping_country,
                    'pincode'       => $request->shipping_zip_code,
                    'address_type'  => 'shipping_address',
                ];
                OrderAddress::create($billing);
                OrderAddress::create($shipping);

        } 
        elseif ($request->billing_address_id === null ) 
        {

            $billing = [
                'order_id'      => $orderId,
                'user_id'       => $user_id,
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'address_2'     => $request->address2,
                'city'          => $request->city,
                'state'         => $request->state,
                'country'       => $request->country,
                'pincode'       => $request->zip_code,
                'address_type'  => 'billing_address',
            ];

            OrderAddress::create($billing);
        } 
        elseif ($request->shipping_address_id === null) 
        {
            // dd('shipping run');
            $shipping = [
                'order_id'      => $orderId,
                'user_id'       => $user_id,
                'name'          => $request->shipping_name,
                'email'         => $request->shipping_email,
                'phone'         => $request->shipping_phone,
                'address'       => $request->shipping_address,
                'address_2'     => $request->shipping_address2,
                'city'          => $request->shipping_city,
                'state'         => $request->shipping_state,
                'country'       => $request->shipping_country,
                'pincode'       => $request->shipping_zip_code,
                'address_type'  => 'shipping_address',
            ];
            OrderAddress::create($shipping);
        }else{
            $saveAddresses = OrderAddress::where('id', $request->billing_address_id)->orWhere('id', $request->shipping_address_id)->first();
            if ($saveAddresses->address_type === 'billing_address') {
               $addressBill = "billing_address";
            //    dd($addressBill);
            }
            if ($saveAddresses->address_type === 'billing_address') {
               $addressShip = "shiping_address";
            //    dd($addressShip);
            }
            // dd($saveAddresses->address_type->billing_address);
            $billing = [
                'order_id'      => $orderId,
                'user_id'       => $user_id,
                'name'          => $saveAddresses->name,
                'email'         => $saveAddresses->email,
                'phone'         => $saveAddresses->phone,
                'address'       => $saveAddresses->address,
                'address_2'     => $saveAddresses->address2,
                'city'          => $saveAddresses->city,
                'state'         => $saveAddresses->state,
                'country'       => $saveAddresses->country,
                'pincode'       => $saveAddresses->pincode,
                'address_type'  => $addressBill,
            ];
            $shipping = [
                'order_id'      => $orderId,
                'user_id'       => $user_id,
                'name'          => $saveAddresses->name,
                'email'         => $saveAddresses->email,
                'phone'         => $saveAddresses->phone,
                'address'       => $saveAddresses->address,
                'address_2'     => $saveAddresses->address2,
                'city'          => $saveAddresses->city,
                'state'         => $saveAddresses->state,
                'country'       => $saveAddresses->country,
                'pincode'       => $saveAddresses->pincode,
                'address_type'  => $addressShip,
            ];
            
            OrderAddress::create($billing);
            OrderAddress::create($shipping);
        }
            // dd($request);
            $cart_id = session('cart_id');
            $cart = Quote::where('cart_id', $cart_id)->first();
            $quoteItems = QuoteItem::where('quote_id', $cart->id)->get();
            
            $orderItems = []; 
            foreach ($quoteItems as $cartItem)
            {
                $orderItems[] = [
                    'order_id'        => $orderId,
                    'product_id'      => $cartItem->product_id,
                    'name'            => $cartItem->name,
                    'sku'             => $cartItem->sku,
                    'price'           => $cartItem->price,
                    'qty'             => $cartItem->qty,
                    'row_total'       => $cartItem->row_total,
                    'coustom_option'  => json_encode($cartItem->coustom_option),
                ];

                $product = Product::find($cartItem->product_id);
                if ($product) 
                {
                    $product->qty -= $cartItem->qty;
                    if ($product->qty == 0) 
                    {
                       $product->stock_status = 0;
                    }
                    elseif ($product->qty <= 5) 
                    {
                       $product->stock_status = 2;
                    }
                    else{
                       $product->stock_status = 1;
                    }
                    Product::where('id',$product->id)->update([
                        'qty' => $product->qty,
                        'stock_status' =>$product->stock_status,
                    ]);
                }
            }
            // Insert all order items at once
            OrderItem::insert($orderItems);
            $order = Order::with(['items', 'addresses'])->where('id', $order->id)->first();
            if ($order) 
            { 
                try{
                    
                    Mail::to($order->email)->send(new OrderEmail($order));
                } 
                catch (\Exception $e){
                    // return redirect()->route('order')->with('error', 'Email could not be sent: ' . $e->getMessage());
                }
            }
            if ($cart)
            {
                $updateCart = [
                    'subtotal'         => null,
                    'coupon'           => null,
                    'coupon_discount'  => null,
                    'total'            => null,
                ];
                 $afterCartUpdate = Quote::where('cart_id',$cart_id)->update($updateCart);
                if ($afterCartUpdate)
                {
                    $quoteItems = QuoteItem::where('quote_id',$cart->id)->get();
                    $Items = [];
                    foreach ($quoteItems as $key => $cartItem)
                    {
                        $Items=[
                            'quote_id'       => NULL,
                            'product_id'     => NULL,
                            'name'           => NULL,
                            'sku'            => NULL,
                            'price'          => NULL,
                            'qty'            => NULL,
                            'row_total'      => NULL,
                            'coustom_option' => NULL,
                        ];
                    }
                    QuoteItem::where('quote_id',$cart->id)->update($Items);
                }
            }
                return redirect()->route('cartShow')->with('success','you order SuccessFully recived ');
    }
}