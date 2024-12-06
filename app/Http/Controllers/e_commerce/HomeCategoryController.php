<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// class HomeCategoryController extends Controller
// {
//     public function CategotyPage(Request $request,$url_key)
//     {

//         // dd($request->search);
//         $category = Category::where('url_key',$url_key)->with('products')->first();
//         $search = $category->products()->where('name','like' ,'%' .$request->search.'%')->get();
//         // dd($search);
//         return view('e-commerce.categories.categorPage',compact('category','search'));
//     }
//     public function catalog(Request $request){
//         dd($request->all());
//     }
// }
class HomeCategoryController extends Controller
{
    public function CategotyPage($urlKey, Request $request)
    {
        $category = Category::where('url_key', $urlKey)->with(['products'])->first();

        // Get the selected price range from the request
        $priceRange = $request->input('price_range');

        // Filter products based on price range if it's selected
        if ($priceRange) {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $filteredProducts = $category->products->filter(function ($product) use ($minPrice, $maxPrice) {
                // Determine the price to use (special price if available)
                $currentDate = date('Y-m-d');
                $specialPriceActive = $product->special_price &&
                $product->special_price_from <= $currentDate &&
                $product->special_price_to >= $currentDate;

                $priceToCheck = $specialPriceActive ? $product->special_price : $product->price;

                return $priceToCheck >= $minPrice && $priceToCheck <= $maxPrice;
            });
        } else {
            $filteredProducts = $category->products;
        }

        return view('e-commerce.categories.categorPage', compact('category', 'filteredProducts'));
    }

    public function catalog(Request $request)
    {
        $search = $request->input('search');
        $priceRange = $request->input('price_range');
        $order = $request->input('order', 'ASC'); // Default to ascending

        // Start with all products
        $productsQuery = Product::query();

        // Filter by search if provided
        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('meta_tag', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter by price range if provided
        if ($priceRange) {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $productsQuery->whereBetween('price', [(float) $minPrice, (float) $maxPrice]);
        }

            // Apply sorting by creation date
            $productsQuery->orderBy('created_at', $order);

            // Retrieve the filtered and sorted products with pagination
            $products = $productsQuery->paginate(10); // Adjust the number of items per page as needed

            // Return the view with the filtered products
            return view('e-commerce.categories.catalog', compact('products'));
    }
    

}