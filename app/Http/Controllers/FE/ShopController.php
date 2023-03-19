<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Price;
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
        $products = Product::orderBy('id', 'DESC')->paginate(16);
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

    public function test()
    {
        $product = Product::find(78);
        dd($product->currentSalePrice);

        // Checking errors before process delete
        $errors = [
            'orderExisted' => count($product->order_details),
            'stockExisted' => count($product->stocks),
            'priceExisted' => count($product->prices),
        ];
        foreach($errors as $key => $val) {
            if ($val > 0) dd(['status' => $key]);
        }

        $products = Product::query();
        $subModel = 'App\Models\Cates\\' . ucfirst('ssd') . 'Group';
        $value = "4,2,3";
        $cateIdRange = array_reduce(explode(",", $value), function ($acc, $cur) use ($subModel) {
            $cateItems = $subModel::find($cur);
            $cateItemsId = $cateItems->cateItems()->pluck('id');
            if (count($cateItemsId) > 0) {
                $acc[] = $cateItems->cateItems()->pluck('id');
            }
            return $acc;
        }, []);
        $products->whereIn('ssd_id', $cateIdRange);
        dd($products->get());



        $product = Product::find(30);
        dd($product->salePrice);
        $value = "5000000,20000000";
        $products = Product::addSelect(['price' => Price::select('sale_discounted')
            ->whereColumn('product_id', 'products.id')
            ->orderByDesc('created_at')
            ->orderByDesc('sale_discounted')
            ->limit(1)]);
        $products->whereIn('id', function ($query) use ($value) {
            $query->select('product_id')
                ->from(with(new Price)->getTable())
                ->orderByDesc('created_at')
                // ->limit(1)
                ->whereBetween('sale_discounted', explode(",", $value));
        });

        dd($products->orderBy('price', 'DESC')->pluck('price'));
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
        $products = $this->getProductsByCate($cate)->orderBy('id', 'DESC')->paginate(16);

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
     * Append latest sale price to 'Product' Model
     * 
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function appendSalePrice($products)
    {
        $products->addSelect(['price' => Price::select('sale_discounted')
            ->whereColumn('product_id', 'products.id')
            ->orderByDesc('created_at')
            ->orderByDesc('sale_discounted')
            ->limit(1)]);
        return $products;
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

        // If default pagination items does not exists, create one by 16
        if (!isset($queries['show'])) {
            $queries['show'] = 16;
        }
        // If default pagination sorting does not exists, create one by ID desc.
        if (!isset($queries['sort'])) {
            $queries['sort'] = 0;
        }

        // Append sale price to products
        $products = $this->appendSalePrice(Product::query());


        // Render seach items by accessing products via Shop page
        if (isset($queries['slug'])) {
            // Render seach items by searching on header
            if (substr($queries['slug'], 0, 12) === 'headerSearch') {
                $header = $queries['slug'];
                $headerQuery = str_replace("+", "%", substr($header, strripos($header, '=') + 1));
                $products = $products->where('name', 'LIKE', '%' . $headerQuery . '%');
            } else {
                // Render seach items by accessing products on nav-bar
                $cate = Cate::where('slug', $queries['slug'])->get()->first();
                $products = $this->appendSalePrice($this->getProductsByCate($cate));
            }
        }


        // Result sorting configs
        $sort = [
            0 => [
                'orderBy' => 'id',
                'direction' => 'DESC'
            ],
            1 => [
                'orderBy' => 'name',
                'direction' => 'ASC'
            ],
            2 => [
                'orderBy' => 'name',
                'direction' => 'DESC'
            ],
            3 => [
                'orderBy' => 'price',
                'direction' => 'DESC'
            ],
            4 => [
                'orderBy' => 'price',
                'direction' => 'ASC'
            ],
        ];
        $sortBy = $sort[$queries['sort']]['orderBy'];
        $sortDirection = $sort[$queries['sort']]['direction'];

        // Render filtered search items
        $products = $products->where(function (Builder $query) use ($queries) {
            foreach ($queries as $key => $value) {
                switch ($key) {
                    case 'page':
                    case 'show':
                    case 'sort':
                    case 'slug':
                    case 'headerSearch':
                        break;
                    case 'price':
                        $query->whereHas('prices', function (Builder $query) use ($value) {
                            $query->whereBetween('sale_discounted', explode(",", $value))->orderBy('id', 'desc');
                        });
                        break;
                    case 'ram':
                    case 'hdd':
                    case 'ssd':
                    case 'screen':
                        $subModel = 'App\Models\Cates\\' . ucfirst($key) . 'Group';
                        $cateIdRange = array_reduce(explode(",", $value), function ($acc, $cur) use ($subModel) {
                            $cateItems = $subModel::find($cur);
                            $cateItemsId = $cateItems->cateItems()->pluck('id');
                            if (count($cateItemsId) > 0) {
                                $acc[] = $cateItemsId;
                            }
                            return $acc;
                        }, []);
                        $query->whereIn($key . '_id', $cateIdRange);
                        break;
                    default:
                        $query->whereIn($key . '_id', explode(",", $value));
                        break;
                }
            }
            return $query;
        });

        // Apply sorting on results
        $products = $products->orderBy($sortBy, $sortDirection);

        // Apply pagination
        $products = $products->paginate($queries['show']);

        return view('fe.home.shopSearch', ['products' => $products])->render();
    }
}
