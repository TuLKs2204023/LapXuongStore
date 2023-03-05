<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Price;
use App\Models\Cate;
use App\Models\CateGroup;
use App\Models\Cates\RamGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->show ?? 3;
        $sortBy  = $request->sort_by ??'latest';

        switch($sortBy)
        {
            case 'latest';
                $products = Product::orderBy('id');
                break;
            case 'oldest':
                $products = Product::orderByDesc('id');
                break;
            case 'name-ascending':
                $products = Product::orderBy('name');
                break;
            case 'name-descending':
                $products = Product::orderByDesc('name');
                // dd($products->get());
                break;
            case 'price-ascending':
                    $products = Price::orderBy('manufacture_id');
                    break;
            case 'price-descending':
                    $products = Price::orderByDesc('manufacture_id');
                    break;
           
            default:
                $products = Product::orderBy('id');
                

        }

        
        //paginate() : ham phan trang

       

        

        $products = $products->paginate($perPage);
        $cateGroups = CateGroup::all()->load('cates');
        return view('fe.home.shop')->with([
            'cateGroups' => $cateGroups,
            'products' => $products,
        ]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cate($slug)
    {
        $cateGroups = CateGroup::all()->load('cates');
        $cate = Cate::where('slug', $slug)->get()->first();
        $cateItems = $cate->cateable;

        if (isset($cateItems->products)) {
            $cateItems->load('products');
            $products = $cateItems->products;
        }
        if (method_exists(get_class($cateItems), 'cateItems')) {
            $products = new Collection();
            foreach ($cateItems->cateItems()->load('products') as $item) {
                $products = $products->merge($item->products);
            }
        }

        return view('fe.home.shop')->with([
            'cateGroups' => $cateGroups,
            'cate' => $cate,
            'cateItems' => $cateItems,
            'products' => $products
        ]);
    }
}
