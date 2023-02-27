<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\FE\HomeController;
use App\Models\CateGroup;

class HeaderController extends HomeController
{

    public static function cateGroups()
    {
        $cateGroups = CateGroup::all();
        return $cateGroups;
    }
}
