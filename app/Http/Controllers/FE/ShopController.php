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
use App\Http\Traits\ProcessModelData;

class ShopController extends Controller
{
    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(8);
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
    public function getProductsByCate($cate)
    {
        $cateItems = $cate->cateable;

        if (isset($cateItems->products)) {
            $cateItems->load('products');
            return $cateItems->products();
        } else {
            $cateMorphClass = $cateItems->getMorphClass();
            $cateClass = substr($cateMorphClass, strripos($cateMorphClass, '\\') + 1, strlen($cateItems->getMorphClass()) - strripos($cateMorphClass, '\\'));
            $cateName = strtolower(substr($cateClass, 0, strlen($cateClass) - 5));
            $cateIdRange = $cateItems->cateItems()->pluck('id');
            return Product::whereIn($cateName . '_id', $cateIdRange);
        }
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
        $products = $this->getProductsByCate($cate)->paginate(12);
        // $products = $this->paginate($products, 9)->setPath(Route('fe.shop.index') . '/' . $slug);

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
        if (!isset($queries['slug'])) {
            $products = Product::query();
        } else {
            $cate = Cate::where('slug', $queries['slug'])->get()->first();
            $products = $this->getProductsByCate($cate);
        }

        $products = $products->where(function (Builder $query) use ($queries) {
            foreach ($queries as $key => $value) {
                switch ($key) {
                    case 'page':
                    case 'show':
                    case 'slug':
                        break;
                    default:
                        $query->whereIn($key . '_id', explode(",", $value));
                        break;
                }
            }
            return $query;
        })->paginate($queries['show']);

        return view('fe.home.shopSearch', ['products' => $products])->render();
    }
}
