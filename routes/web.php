<?php

use Illuminate\Support\Facades\Route;

// admin Controller
use App\Http\Controllers\admin\MailController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\BlockController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\EnquiryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\e_commerce\CartController;
use App\Http\Controllers\e_commerce\HomeController;
use App\Http\Controllers\admin\PermissionController;


// e_commerce Controller
use App\Http\Controllers\e_commerce\OrderController;
use App\Http\Controllers\admin\ManageOrderController;
use App\Http\Controllers\e_commerce\ContectController;
use App\Http\Controllers\e_commerce\ProfileController;
use App\Http\Controllers\e_commerce\CheckoutController;
use App\Http\Controllers\e_commerce\WishlistController;
use App\Http\Controllers\admin\AttributevalueController;
use App\Http\Controllers\e_commerce\UserLoginController;
use App\Http\Controllers\e_commerce\NewsletterController;
use App\Http\Controllers\e_commerce\HomeCategoryController;
use App\Http\Controllers\e_commerce\UserRegisterController;
use App\Http\Controllers\e_commerce\ProductDetailController;
use App\Http\Controllers\e_commerce\RazorpayPaymentController;


    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::post('/login-post',[UserLoginController::class,'loginPost'])->name('User_loginPost');
    Route::group(['prefix'=>'e-commerce'], function(){
        // page
        Route::get('/page/{url_key}',[HomeController::class,'page'])->name('page');
        Route::post('/news/letter',[NewsletterController::class,'store'])->name('newsletter');
        
        // ContectController
        Route::get('/contact-us',[ContectController::class,'getform'])->name('contact');
        Route::post('/contact/post',[ContectController::class,'contactPost'])->name('contactPost');
        Route::post('/send/review',[ContectController::class,'sendReview'])->name('sendReview');

        Route::get('/category/{url_key}',[HomeCategoryController::class,'CategotyPage'])->name('CategotyPage');
        Route::get('/category',[HomeCategoryController::class,'catalog'])->name('catalog');

        Route::get('/productdetail/{url_key}',[ProductDetailController::class,'ProductDetailPage'])->name('productdetail');

    
        Route::post('/shipping-cost', [CheckoutController::class, 'shipping_cost'])->name('shipping_cost');

        Route::get('/catr/Show',[CartController::class,'cartShow'])->name('cartShow');
        Route::get('/remove/coupon/{id}',[CartController::class,'removeCoupon'])->name('remove_coupon');
        Route::post('/catr/store',[CartController::class,'CartStore'])->name('CartStore');
        
        Route::post('/coupon/discount',[CartController::class,'couponDiscount'])->name('couponDiscount');
        Route::put('/catr/QtyUpdate/{id}',[CartController::class,'QtyUpdate'])->name('QtyUpdate');
        Route::delete('/item-delete/{id}',[CartController::class,'ItemDelete'])->name('ItemDelete');
        // web site register route
        Route::get('/user/register-form',[UserRegisterController::class,'registerForm'])->name('register_form');
        Route::post('/register-post',[UserRegisterController::class,'registerPost'])->name('registerPost');

        // web site login logout route
        Route::get('/user/login-form',[UserLoginController::class,'loginForm'])->name('login_form');


        // middleware apply if user is not auth. in the web site not access this url's 
       

            Route::get('/user/logout',[UserLoginController::class,'Userlogout'])->name('Userlogout');
            Route::get('/wishlist',[WishlistController::class,'wishlistindex'])->name('wishlist');
            Route::get('/wishlist/post/{id}',[WishlistController::class,'wishlistPost'])->name('wishlistPost');
            Route::delete('/wishlist/delete/{id}',[WishlistController::class,'wishlistDelete'])->name('wishlistDelete');
            // profile
            Route::get('/user-profile',[ProfileController::class,'userProfile'])->name('userProfile');
            Route::get('/order/show/{id}', [ProfileController::class, 'show'])->name('orderShow');
            Route::post('/user-change-password',[ProfileController::class,'changePass'])->name('changePass');
            Route::post('/user/profile-update',[ProfileController::class,'userProfileUpdate'])->name('userProfileUpdate');
            Route::get('/checkout', [CheckoutController::class, 'CheckoutForm'])->name('checkout');
            
            Route::post('/order-place', [OrderController::class, 'orderPlace'])->name('orderPlace');

            Route::get('/orders/{id}', [ManageOrderController::class, 'orders'])->name('orders');
        
            Route::get('/invoice/{id}', [ManageOrderController::class, 'generateInvoice'])->name('generateInvoice');
            Route::get('/razorpay-payment', [RazorpayPaymentController::class, 'index']);
            Route::post('razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
            // CheckoutController route
     
        
        




    });

   


    // this admin panel routes
   
    Route::post('admin/login-post',[LoginController::class,'loginPost'])->name('loginPost');
    
    Route::get('admin/', [LoginController::class, 'index'])->name('login');


        // custom middleware apply frant user not access admin panel 
    Route::group(['middleware'=>['auth',] , 'prefix'=>'admin'],function(){
        Route::get('admin/logout',[LoginController::class,'logout'])->name('admin.logout');
        Route::get('/dasboard',[DashboardController::class,'index'])->name('dashboard.index');
       
        Route::resource('/user',UserController::class);
        Route::get('/change/password',[UserController::class,'userPassword'])->name('user.userPassword');
        Route::post('/update/password',[UserController::class,'updatePassword'])->name('user.updatePassword');
        Route::get('/profile',[UserController::class,'profile'])->name('user.profile');

        Route::resource('/permission',PermissionController::class);

        Route::resource('/role',RoleController::class);

        Route::resource('/slider',SliderController::class);

        Route::resource('/page',PageController::class);

        Route::resource('/block',BlockController::class);


        Route::resource('/product',ProductController::class);

        Route::resource('/attribute',AttributeController::class);

        Route::resource('/attributevalue',AttributevalueController::class);

        Route::resource('/category',CategoryController::class);

        Route::resource('/coupon',CouponController::class);

        Route::resource('/brand',BrandController::class);

        
        Route::get('/enquiries',[EnquiryController::class ,'index'])->name('enquiries.index');
        Route::get('/enquiries/{id}', [EnquiryController::class, 'enquiryRead'])->name('enquiries.enquiryRead');
        Route::delete('/enquiries/{id}', [EnquiryController::class, 'delete'])->name('enquiries.delete');
        
        
        Route::get('/order',[ManageOrderController::class , 'index'])->name('order');
        Route::get('/order/show/{id}', [ManageOrderController::class, 'orderShow'])->name('admin.orderShow');
        Route::get('/order/show/{id}/sendEmail', [ManageOrderController::class, 'sendEmail']);


      

    });
