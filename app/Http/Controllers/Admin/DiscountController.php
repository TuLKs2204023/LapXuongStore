<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all()->sortByDesc('id');
        // $stocks = Stock::all();
        return view('admin.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        $products = Product::all();
        return view('admin.discount.create', compact('products', 'isUpdate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proData = $this->processDataWithOutSlug($request);

        $product = Product::where('name', $proData['product_name'])->get()->first();

        // Save stock for this product
        $product = $this->processDiscount($product, $proData);
        
        $success = 'Successfully added discount for '. $product->name;

        return redirect()->route('admin.discount.index')->with('success', $success);
    }

    public function discountDetails(Request $request)
    {
        $pid = $request->id;
        $product = Product::where('id', $pid)->get()->first();
        $product->load('discounts');

        return view('admin.discount.details', compact('product'));
    }

    public function createDiscountByDetails(int $id)
    {
        $isUpdate = true;
        $product = Product::find($id);
        return view('admin.discount.createByDetails')->with(['product' => $product], ['isUpdate' => $isUpdate]);
    }





















    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
