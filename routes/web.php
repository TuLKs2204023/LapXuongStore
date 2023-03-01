<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CateController;
use App\Http\Controllers\Admin\Cates\ManufactureController;
use App\Http\Controllers\Admin\Cates\CpuController;
use App\Http\Controllers\Admin\Cates\RamGroupController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\FE\HomeController as FE_HomeController;
use App\Http\Controllers\FE\ShopController;
use App\Http\Controllers\Admin\StockController;

use App\Http\Controllers\backend\OdersController;

use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\WishlistItemController;
use App\Models\WishlistItem;

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
Route::get('/manager', [AdminHomeController::class, 'manager'])->name('admin.dashboard');
Route::get('/customer', [AdminHomeController::class, 'customer'])->name('customer');

Route::get('/back-from-error', [AdminHomeController::class, 'backFromError'])->name('admin.backFromError');





Route::get('/', [FE_HomeController::class, 'index'])->name('fe.home');
Route::get('/contact', [FE_HomeController::class, 'contact'])->name('fe.contact');
Route::get('/shop', [ShopController::class, 'index'])->name('fe.shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'cate'])->name('fe.shop.cate');


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

//Order management
Route::get('/allorders', [OdersController::class, 'Allorders'])->name('allorders');

// Checkout Order
Route::get('/display-checkout', [FE_HomeController::class, 'displayCheckout'])->name('displayCheckout');

// Product details
Route::get('/product/{slug}', [FE_HomeController::class, 'product'])->name('product.details');

// Cart Controller
Route::post('/add-cart', [FE_HomeController::class, 'addCart'])->name('addCart');
Route::post('/update-cart', [FE_HomeController::class, 'updateCart'])->name('updateCart');
Route::post('/remove-cart', [FE_HomeController::class, 'removeCart'])->name('removeCart');
Route::get('/view-cart', [FE_HomeController::class, 'viewCart'])->name('viewCart');
Route::get('/clear-cart', [FE_HomeController::class, 'clearCart'])->name('clearCart');

// Wishlist
Route::get('/wishlist', [WishlistItemController::class, 'index'])->name('wishlist');
Route::get('/{id}/add_wishlist', [WishlistItemController::class, 'store'])->name('addWishlist');
Route::get('/{id}/remove_wishlist', [WishlistItemController::class, 'destroy'])->name('removeWishlist');


// For Login purpose
// Route::group(['middleware' => 'canLogin'], function () {
// Checkout
Route::get('/checkout', [FE_HomeController::class, 'checkout'])->name('checkout');
Route::post('/process-checkout', [FE_HomeController::class, 'processCheckout'])->name('processCheckout');

// For Admin purpose
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // User
    Route::resource('/user', UserController::class);

    //Wishlist
    Route::group(['prefix' => 'wishlist', 'as' => 'wishlist.'], function () {
        Route::get('/', [WishlistItemController::class, 'adminIndex'])->name('index');
    });

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
        Route::get('/create', [CateController::class, 'create'])->name('create');
        Route::post('/store', [CateController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CateController::class, 'edit'])->name('edit');
        Route::put('/update', [CateController::class, 'update'])->name('update');
        Route::delete('/destroy', [CateController::class, 'destroy'])->name('destroy');
    });

    // Manufacture
    Route::group(['prefix' => 'manufacture', 'as' => 'manufacture.'], function () {
        Route::get('/', [ManufactureController::class, 'index'])->name('index');
        Route::get('/create', [ManufactureController::class, 'create'])->name('create');
        Route::post('/store', [ManufactureController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ManufactureController::class, 'edit'])->name('edit');
        Route::put('/update', [ManufactureController::class, 'update'])->name('update');
        Route::delete('/destroy', [ManufactureController::class, 'destroy'])->name('destroy');
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
});
