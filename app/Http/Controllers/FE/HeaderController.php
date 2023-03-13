<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\FE\HomeController;
use App\Models\CateGroup;
use App\Models\Product;

class HeaderController extends HomeController
{

    public static function cateGroups()
    {
        $cateGroups = CateGroup::all();
        return $cateGroups;
    }

    public static function header_products(){
        $header_products = Product::all();
        return $header_products;
    }
}
