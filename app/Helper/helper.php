<?php 
use App\Models\Page;
use App\Models\Brand;
use App\Models\Quote;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\QuoteItem;
use Illuminate\Support\Carbon;


  // HeadPages
  function HeadPages(){

    $pages=Page::where('status',1)->where('show_in_menu',1)->get();
    return $pages;

 }

  //  FooterPages
//   function FooterPages(){

//     $pages=Page::where('status',1)->where('show_in_footer',1)->get();
//     return $pages;

//  }
// In your helper file (e.g., app/Helpers/helpers.php)

function FooterPages(){
  $pages = Page::where('status', 1)->where('show_in_footer', 1)->get();
  
  // Split the pages into two parts: First 4 and the rest
  $firstPart = $pages->take(4);  // First 4 pages
  $secondPart = $pages->slice(4);  // Pages after the first 4
  // Return both parts as an array
  return [
      'firstPart' => $firstPart,
      'secondPart' => $secondPart,
  ];
}



  //  categories
  function categories(){

    $categories=Category::where('status',1)->where('parent_category',0)->get();
    return $categories;

 }

  // subCategory
  function Subcategories($parent_category){
    $SubCategories=Category::where('status',1)->where('parent_category',$parent_category)->get();
    return $SubCategories;

  }

  //All Category Get this  method

  function AllCategories(){

    $categories=Category::where('status',1)->get();
    return $categories;

  }



  //  Featured_products
  function Featured_products(){

    $products = Product::where('status', 1)->where('is_featured', 1)->get();
    return $products;

  }

    //  Recent_products
  function Recent_products(){

    $products = Product::where('status', 1)->orderBy('created_at', 'DESC')->take(10)->get();
    return $products;


  }


  //  this helper show present data accorading price date

  if (!function_exists('displayPrice')) {
    function displayPrice($productDetail, $returnHtml = true) {
        $now = \Carbon\Carbon::now();

        if ($productDetail->special_price && $productDetail->special_price_from <= $now && $productDetail->special_price_to >= $now) {
        
            if ($returnHtml) {
              return ' <s>₹' . $productDetail->price . '</s>&nbsp;<strong>₹' . $productDetail->special_price . '</strong> ';
          
            } else {
                return $productDetail->special_price;
            }
        } else {
            if ($returnHtml) {
                return '<h3 class="h6" style="font-weight:bold;">₹' . $productDetail->price . '</h3>';
            } else {
                return $productDetail->price;
            }
        }
    }

  }


  // count of card data in exists and show in card icon
  function allItemsInCart() {
    $cartId = Session('cart_id');
    
    if ($cartId !== null) {
        $data = Quote::where('cart_id', $cartId)->orwhere('user_id',Auth::user()->id ?? '')->first();
        
        if ($data) {
            return QuoteItem::with('product')->where('quote_id', $data->id)->get();
        } else {
            return collect(); // Return an empty collection if no quote found
        }
    } else {
        return collect(); // Return an empty collection if cart_id is null
    }
}



  // count of All Wishlist data in exists and show in Wishlist icon !
  function AllWishlistData(){
    if ($uId=Auth::user()->id) {
      $uId=Auth::user()->id;
      $wishListItems = Wishlist::with('Product')->where('user_id',$uId)->get();
      return $wishListItems ;
    }
  }

function Brands(){
  return $brands = Brand::where('status',1)->get();
}

?>
