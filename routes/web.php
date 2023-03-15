<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CateController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\WishlistItemController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountController;

use App\Http\Controllers\Admin\Cates\ColorController;
use App\Http\Controllers\Admin\Cates\ManufactureController;
use App\Http\Controllers\Admin\Cates\CpuController;
use App\Http\Controllers\Admin\Cates\DemandController;
use App\Http\Controllers\Admin\Cates\GpuController;
use App\Http\Controllers\Admin\Cates\HddGroupController;
use App\Http\Controllers\Admin\Cates\RamGroupController;
use App\Http\Controllers\Admin\Cates\ResolutionController;
use App\Http\Controllers\Admin\Cates\ScreenGroupController;
use App\Http\Controllers\Admin\Cates\SeriesController;
use App\Http\Controllers\Admin\Cates\SsdGroupController;

use App\Http\Controllers\FE\HomeController as FE_HomeController;
use App\Http\Controllers\FE\ShopController;
use App\Http\Controllers\FE\CheckoutController;

use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\OdersController;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FE\HeaderController;
use App\Http\Controllers\OrderDetailsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin.dashboard');
Route::get('/customer', [FE_HomeController::class, 'userProfile'])->name('userProfile');
Route::get('/back-from-error', [AdminHomeController::class, 'backFromError'])->name('admin.backFromError');
Route::get('/product-history', [AdminHomeController::class, 'historyProduct'])->name('historyProduct');



Route::get('/about-us', [FE_HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/', [FE_HomeController::class, 'index'])->name('fe.home');
Route::get('/contact', [FE_HomeController::class, 'contact'])->name('fe.contact');
Route::get('/shop', [ShopController::class, 'index'])->name('fe.shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'cate'])->name('fe.shop.cate');
Route::get('/shop-search', [ShopController::class, 'search'])->name('fe.shop.search');


//Header Search
Route::get('/search', [HeaderController::class, 'header_products'])->name('fe.header.search');

//Data tables
Route::get('/datatable', function () {
    return view('backend.datatable');
});

//User management
Route::get('/all-user', [UserController::class, 'AllUser'])->name('alluser');
Route::get('/add-user-index', [UserController::class, 'AddUserIndex'])->name('adduserindex');
Route::post('/insert-user', [UserController::class, 'InsertUser'])->name('insertuser');
Route::get('/edit-user/{id}', [UserController::class, 'EditUser'])->name('edituser');
Route::post('/update-user/{id}', [UserController::class, 'UpdatetUser'])->name('updateuser');
Route::get('/delete-user/{id}', [UserController::class, 'DeleteUser'])->name('deleteuser');
Route::get('/info-user', [UserController::class, 'InfoUser'])->name('infouser');
Route::get('/edit-byuser/{id}', [UserController::class, 'EditByUser'])->name('editbyuser');
Route::post('/update-byuser/{id}', [UserController::class, 'UpdateByUser'])->name('updatebyuser');
Route::get('/profile', [FE_HomeController::class, 'userProfile'])->name('userProfile');
Route::get('/passwordUser/{id}', [UserController::class, 'passwordUser'])->name('passwordUser');
Route::post('/password-user/{id}', [UserController::class, 'EditpasswordUser'])->name('EditpasswordUser');

//report users
Route::get('admin/lastweek', [DashboardController::class, 'lastweek'])->name('lastweek');

//Dropdown Address Controller
Route::get('city', [DropdownController::class, 'fetchCity']);
Route::post('api/fetch-district', [DropdownController::class, 'fetchDistrict'])->name('fetchDistrict');
Route::post('api/fetch-ward', [DropdownController::class, 'fetchWard'])->name('fetchWard');

//Google authentication controller
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

//Facebook authentication controller
Route::controller(FacebookController::class)->group(function () {
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});

// Product details
Route::get('/product/{slug}', [FE_HomeController::class, 'product'])->name('product.details');

// Cart Controller
Route::post('/add-cart', [FE_HomeController::class, 'addCart'])->name('addCart');
Route::post('/update-cart', [FE_HomeController::class, 'updateCart'])->name('updateCart');
Route::post('/remove-cart', [FE_HomeController::class, 'removeCart'])->name('removeCart');
Route::get('/view-cart', [FE_HomeController::class, 'viewCart'])->name('viewCart');
Route::get('/clear-cart', [FE_HomeController::class, 'clearCart'])->name('clearCart');
Route::post('/empty-cart', [FE_HomeController::class, 'emptyCart'])->name('emptyCart');

// For Login purpose
Route::group(['middleware' => 'auth'], function () {
    //User Orders
    Route::get('/user/orders', [OdersController::class, 'userAllOrders'])->name('userOrders');
    Route::get('/user/{id}/order-details', [OrderDetailsController::class, 'userRights'])->name('userOrderDetails');
    Route::get('/check-order', [OdersController::class, 'afterCheckOut'])->name('afterCheckOut');

    // Wishlist
    Route::get('/wishlist', [WishlistItemController::class, 'index'])->name('wishlist');
    Route::post('/add_wishlist', [WishlistItemController::class, 'store'])->name('addWishlist');
    Route::delete('/remove_wishlist', [WishlistItemController::class, 'userDestroy'])->name('removeWishlist');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/thankyou', [CheckoutController::class, 'asd'])->name('asd');
    Route::post('/process-checkout', [CheckoutController::class, 'processCheckout'])->name('processCheckout');

    // Coupon
    Route::post('/coupon-check', [CheckoutController::class, 'couponCheck'])->name('couponCheck');

    // For Admin purpose
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        // Dashboard
        Route::group(['prefix' => 'wishlist', 'as' => 'wishlist.'], function () {
            Route::get('/', [WishlistItemController::class, 'adminIndex'])->name('index');
            // Route::get('/create', [WishlistItemController::class, 'create'])->name('create');
            // Route::post('/store', [WishlistItemController::class, 'store'])->name('store');
            // Route::get('/{id}/edit', [WishlistItemController::class, 'edit'])->name('edit');
            // Route::put('/update', [WishlistItemController::class, 'update'])->name('update');
            Route::delete('/destroy', [WishlistItemController::class, 'adminDestroy'])->name('destroy');
        });

        // User
        Route::resource('/user', UserController::class);

        // Product
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/update', [ProductController::class, 'update'])->name('update');
            Route::delete('/destroy', [ProductController::class, 'destroy'])->name('destroy');
        });

        // Category
        Route::group(['prefix' => 'cate', 'as' => 'cate.'], function () {
            Route::get('/', [CateController::class, 'index'])->name('index');
            Route::get('/refresh', [CateController::class, 'refresh'])->name('refresh');
            Route::post('/store', [CateController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CateController::class, 'edit'])->name('edit');
            Route::put('/update', [CateController::class, 'update'])->name('update');
            Route::delete('/destroy', [CateController::class, 'destroy'])->name('destroy');
            Route::post('/toggle-display', [CateController::class, 'toggleDisplay'])->name('toggleDisplay');
        });

        // Manufacture
        Route::group(['prefix' => 'manufacture', 'as' => 'manufacture.'], function () {
            Route::get('/', [ManufactureController::class, 'index'])->name('index');
            Route::get('/create', [ManufactureController::class, 'create'])->name('create');
            Route::post('/store', [ManufactureController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ManufactureController::class, 'edit'])->name('edit');
            Route::put('/update', [ManufactureController::class, 'update'])->name('update');
            Route::delete('/destroy', [ManufactureController::class, 'destroy'])->name('destroy');
            Route::post('/get-series-by-brand', [ManufactureController::class, 'getSeriesByBrand'])->name('getSeriesByBrand');
        });

        // CPU
        Route::group(['prefix' => 'cpu', 'as' => 'cpu.'], function () {
            Route::get('/', [CpuController::class, 'index'])->name('index');
            Route::get('/create', [CpuController::class, 'create'])->name('create');
            Route::post('/store', [CpuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CpuController::class, 'edit'])->name('edit');
            Route::put('/update', [CpuController::class, 'update'])->name('update');
            Route::delete('/destroy', [CpuController::class, 'destroy'])->name('destroy');
        });

        // RAM's Group
        Route::group(['prefix' => 'ramGroup', 'as' => 'ramGroup.'], function () {
            Route::get('/', [RamGroupController::class, 'index'])->name('index');
            Route::get('/create', [RamGroupController::class, 'create'])->name('create');
            Route::post('/store', [RamGroupController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [RamGroupController::class, 'edit'])->name('edit');
            Route::put('/update', [RamGroupController::class, 'update'])->name('update');
            Route::delete('/destroy', [RamGroupController::class, 'destroy'])->name('destroy');
        });

        // Screen's Group
        Route::group(['prefix' => 'screenGroup', 'as' => 'screenGroup.'], function () {
            Route::get('/', [ScreenGroupController::class, 'index'])->name('index');
            Route::get('/create', [ScreenGroupController::class, 'create'])->name('create');
            Route::post('/store', [ScreenGroupController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ScreenGroupController::class, 'edit'])->name('edit');
            Route::put('/update', [ScreenGroupController::class, 'update'])->name('update');
            Route::delete('/destroy', [ScreenGroupController::class, 'destroy'])->name('destroy');
        });

        // HDD's Group
        Route::group(['prefix' => 'hddGroup', 'as' => 'hddGroup.'], function () {
            Route::get('/', [HddGroupController::class, 'index'])->name('index');
            Route::get('/create', [HddGroupController::class, 'create'])->name('create');
            Route::post('/store', [HddGroupController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [HddGroupController::class, 'edit'])->name('edit');
            Route::put('/update', [HddGroupController::class, 'update'])->name('update');
            Route::delete('/destroy', [HddGroupController::class, 'destroy'])->name('destroy');
        });

        // SSD's Group
        Route::group(['prefix' => 'ssdGroup', 'as' => 'ssdGroup.'], function () {
            Route::get('/', [SsdGroupController::class, 'index'])->name('index');
            Route::get('/create', [SsdGroupController::class, 'create'])->name('create');
            Route::post('/store', [SsdGroupController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SsdGroupController::class, 'edit'])->name('edit');
            Route::put('/update', [SsdGroupController::class, 'update'])->name('update');
            Route::delete('/destroy', [SsdGroupController::class, 'destroy'])->name('destroy');
        });

        // Color
        Route::group(['prefix' => 'color', 'as' => 'color.'], function () {
            Route::get('/', [ColorController::class, 'index'])->name('index');
            Route::get('/create', [ColorController::class, 'create'])->name('create');
            Route::post('/store', [ColorController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ColorController::class, 'edit'])->name('edit');
            Route::put('/update', [ColorController::class, 'update'])->name('update');
            Route::delete('/destroy', [ColorController::class, 'destroy'])->name('destroy');
        });

        // GPU
        Route::group(['prefix' => 'gpu', 'as' => 'gpu.'], function () {
            Route::get('/', [GpuController::class, 'index'])->name('index');
            Route::get('/create', [GpuController::class, 'create'])->name('create');
            Route::post('/store', [GpuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GpuController::class, 'edit'])->name('edit');
            Route::put('/update', [GpuController::class, 'update'])->name('update');
            Route::delete('/destroy', [GpuController::class, 'destroy'])->name('destroy');
        });

        // Demand
        Route::group(['prefix' => 'demand', 'as' => 'demand.'], function () {
            Route::get('/', [DemandController::class, 'index'])->name('index');
            Route::get('/create', [DemandController::class, 'create'])->name('create');
            Route::post('/store', [DemandController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DemandController::class, 'edit'])->name('edit');
            Route::put('/update', [DemandController::class, 'update'])->name('update');
            Route::delete('/destroy', [DemandController::class, 'destroy'])->name('destroy');
        });

        // Series
        Route::group(['prefix' => 'series', 'as' => 'series.'], function () {
            Route::get('/', [SeriesController::class, 'index'])->name('index');
            Route::get('/create', [SeriesController::class, 'create'])->name('create');
            Route::post('/store', [SeriesController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SeriesController::class, 'edit'])->name('edit');
            Route::put('/update', [SeriesController::class, 'update'])->name('update');
            Route::delete('/destroy', [SeriesController::class, 'destroy'])->name('destroy');
        });

        // Resolution
        Route::group(['prefix' => 'resolution', 'as' => 'resolution.'], function () {
            Route::get('/', [ResolutionController::class, 'index'])->name('index');
            Route::get('/create', [ResolutionController::class, 'create'])->name('create');
            Route::post('/store', [ResolutionController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ResolutionController::class, 'edit'])->name('edit');
            Route::put('/update', [ResolutionController::class, 'update'])->name('update');
            Route::delete('/destroy', [ResolutionController::class, 'destroy'])->name('destroy');
        });

        // STOCK
        Route::group(['prefix' => 'stock', 'as' => 'stock.'], function () {

            Route::get('/', [StockController::class, 'index'])->name('index');
            Route::get('/{id}/details', [StockController::class, 'stockDetails'])->name('details');
            Route::get('/{id}/create', [StockController::class, 'createStockByDetails'])->name('createStockByDetails');
            Route::post('/store-details', [StockController::class, 'storeStockByDetails'])->name('storeStockByDetails');
            Route::get('/create', [StockController::class, 'create'])->name('create');
            Route::post('/store', [StockController::class, 'store'])->name('store');
            // Route::get('/{id}/edit', [StockController::class, 'edit'])->name('edit');
            // Route::put('/update', [StockController::class, 'update'])->name('update');
            // Route::delete('/destroy', [StockController::class, 'destroy'])->name('destroy');
        });

        // DISCOUNT
        Route::group(['prefix' => 'discount', 'as' => 'discount.'], function () {

            Route::get('/', [DiscountController::class, 'index'])->name('index');
            Route::get('/{id}/details', [DiscountController::class, 'discountDetails'])->name('details');
            Route::get('/{id}/create', [DiscountController::class, 'createDiscountByDetails'])->name('createDiscountByDetails');
            Route::post('/store-details', [DiscountController::class, 'storeDiscountByDetails'])->name('storeDiscountByDetails');
            Route::get('/create', [DiscountController::class, 'create'])->name('create');
            Route::post('/store', [DiscountController::class, 'store'])->name('store');
            // Route::get('/{id}/edit', [StockController::class, 'edit'])->name('edit');
            // Route::put('/update', [StockController::class, 'update'])->name('update');
            // Route::delete('/destroy', [StockController::class, 'destroy'])->name('destroy');
        });

        //PROMOTION
        Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function () {
            Route::get('/', [PromotionController::class, 'index'])->name('index');
            // Route::get('/create', [PromotionController::class, 'create'])->name('create');
            Route::post('/store', [PromotionController::class, 'store'])->name('store');
            // Route::get('/{id}/edit', [PromotionController::class, 'edit'])->name('edit');
            // Route::put('/update', [PromotionController::class, 'update'])->name('update');
            // Route::delete('/destroy', [PromotionController::class, 'destroy'])->name('destroy');
        });

        // Rating
        Route::group(['prefix' => 'rating', 'as' => 'rating.'], function () {
            Route::get('/', [RatingController::class, 'index'])->name('index');
            Route::get('/create', [RatingController::class, 'create'])->name('create');
            Route::post('/store', [RatingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [RatingController::class, 'edit'])->name('edit');
            Route::put('/update', [RatingController::class, 'update'])->name('update');
            Route::delete('/destroy', [RatingController::class, 'destroy'])->name('destroy');
        });

        //Order management
        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
            Route::get('/all-orders', [OdersController::class, 'Allorders'])->name('allorders');
            //OrderDetails
            Route::get('/{id}/details', [OrderDetailsController::class, 'adminRights'])->name('details');
        });
    });
});
