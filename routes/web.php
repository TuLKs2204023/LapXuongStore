<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CateController;
use App\Http\Controllers\Admin\Cates\CpuController;
use App\Http\Controllers\Admin\Cates\ManufactureController;
use App\Http\Controllers\Admin\Cates\RamController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\FE\HomeController as FE_HomeController;

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
Route::get('/home', [AdminHomeController::class, 'index'])->name('home');


Route::get('/', [FE_HomeController::class, 'index'])->name('feHome');
Route::get('/contact', [FE_HomeController::class, 'contact'])->name('contact');
Route::get('/shop', [FE_HomeController::class, 'shop'])->name('shop');
// Route::get('/', function () {
//     return view('welcome');
// });

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
Route::get('/edit-byuser/{id}', [UserController::class, 'EditByUser'])->name('editby');

// Anh Kiện


Route::get('/display-checkout', [FE_HomeController::class, 'displayCheckout'])->name('displayCheckout');

// Product details
Route::get('/product/{slug}', [FE_HomeController::class, 'product'])->name('product.details');

// Cart Controller
Route::post('/add-cart', [FE_HomeController::class, 'addCart'])->name('addCart');
Route::post('/update-cart', [FE_HomeController::class, 'updateCart'])->name('updateCart');
Route::post('/remove-cart', [FE_HomeController::class, 'removeCart'])->name('removeCart');
Route::get('/view-cart', [FE_HomeController::class, 'viewCart'])->name('viewCart');
Route::get('/clear-cart', [FE_HomeController::class, 'clearCart'])->name('clearCart');

// For Login purpose
// Route::group(['middleware' => 'canLogin'], function () {
// Checkout
Route::get('/checkout', [FE_HomeController::class, 'checkout'])->name('checkout');
Route::post('/process-checkout', [FE_HomeController::class, 'processCheckout'])->name('processCheckout');

// For Admin purpose
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard


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

    // RAM
    Route::group(['prefix' => 'ram', 'as' => 'ram.'], function () {

        Route::get('/', [RamController::class, 'index'])->name('index');
        Route::get('/create', [RamController::class, 'create'])->name('create');
        Route::post('/store', [RamController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RamController::class, 'edit'])->name('edit');
        Route::put('/update', [RamController::class, 'update'])->name('update');
        Route::delete('/destroy', [RamController::class, 'destroy'])->name('destroy');
    });


    // Route::resource('/product', ProductController::class);
});
// });