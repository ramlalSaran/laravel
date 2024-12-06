<?php

namespace App\Http\Controllers\admin;
use Gate;
use App\Models\User;
use App\Models\Order;
use App\Models\Enquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
 
        
        public function index()
        {
            abort_if(Gate::denies('dashboard_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
            $penddingEnquery = Enquiry::where('status',2)->get();
            $allPenddingEquiry = count($penddingEnquery);

            $currentMonthOrders = Order::whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->get();
            $allOrders = count($currentMonthOrders);
            $products = Product::all();
            $allProduct = count($products);
            
            // Total number of users
            $allUser = User::count();
        
            return view('admin.dashboard.index', compact('allUser','allPenddingEquiry','allProduct','allOrders'));
        }
    }

