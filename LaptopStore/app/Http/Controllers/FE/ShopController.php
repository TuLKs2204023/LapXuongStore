<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cate;
use App\Models\CateGroup;
use App\Models\Cates\RamGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Service\Product\ProductServiceInterface;
use App\Service\ProductComment\ProductCommentServiceInterface;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $productService;
     private $productCommentService;
     public function __construct(ProductServiceInterface $productService, 
     ProductCommentServiceInterface $productCommentService )
        {  
            $this->productService = $productService;
            $this->productCommentService = $productCommentService;
        }

        public function show($id)
        {
            $product = $this->productService->find($id);
            $relatedProduct = $this->productService->getRelatedProducts($product);

            return view('fe.home.product',compact('product','relatedProduct'));
        }

        public function postComment(Request $request)
        {
            $this->productCommentService->create($request->all());
            return redirect()->back();
        }

        public function index(Request $request)
        {
            $products = $this->productService->getProductOnIndex($request);

            return view('fe.home.index', compact('products'));
        }



    // public function index()
    // {
    //     $products = Product::all();
    //     $cateGroups = CateGroup::all()->load('cates');
    //     return view('fe.home.shop')->with([
    //         'cateGroups' => $cateGroups,
    //         'products' => $products,
    //     ]);
    // }

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
