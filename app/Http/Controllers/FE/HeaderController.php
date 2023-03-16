<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\FE\HomeController;
use App\Models\CateGroup;
use App\Models\Product;
use Illuminate\Http\Request;

class HeaderController extends HomeController
{

    public static function cateGroups()
    {
        $cateGroups = CateGroup::all();
        return $cateGroups;
    }

    public static function header_products(Request $request)
    {
        $headerSearch = $request->headerSearch;
        $products = Product::where('name', 'like', '%' . str_replace(" ", "%", $headerSearch) . '%')->orderBy('id', 'DESC')->paginate(12);
        $cateGroups = CateGroup::all()->load('cates');
        return view('fe.home.shop', compact('products', 'cateGroups', 'headerSearch'));
    }
}
