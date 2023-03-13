<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cate;
use App\Models\CateGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(9);
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
            $products = $this->paginate($products, 9);
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
        $queries = $request->query();
        $products = Product::where(function (Builder $query) use ($queries) {
            foreach ($queries as $key => $value) {
                if ($key == 'page') continue;
                $query->whereIn($key . '_id', explode(",", $value));
            }
            return $query;
        })->paginate(9);

        return view('fe.home.shopSearch', ['products' => $products])->render();

        return response()->json([
            'success' => true,
            'products' => $products,
            'pagination' => (string)$products->links()
        ]);
    }
}
