<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cate;
use App\Models\CateGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        // $products = Product::all();
        $cateGroups = CateGroup::all()->load('cates');
        return view('fe.home.shop')->with([
            'cateGroups' => $cateGroups,
            'products' => $products,
        ]);
    }

    /**
     * Display products based on category specified by user.
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
            $products = $cateItems->products()->paginate(10);
        }
        if (method_exists(get_class($cateItems), 'cateItems')) {
            $products = new Collection();
            foreach ($cateItems->cateItems()->load('products') as $item) {
                $products = $products->merge($item->products);
            }
            $products = $this->paginate($products);
        }

        return view('fe.home.shop')->with([
            'cateGroups' => $cateGroups,
            'cate' => $cate,
            'cateItems' => $cateItems,
            'products' => $products
        ]);
    }

    /**
     * Generates the pagination of the items for an array or collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    /**
     * Display products based on queries specified by user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $queries = $request->queries;
        $products = DB::table('products');
        foreach ($queries as $key => $value) {
            $products->orWhereIn($key . '_id', $value);
        }
        return $products->paginate(10);;
    }
}
