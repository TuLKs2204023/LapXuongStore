<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\ProcessModelData;
use App\Models\Stock;

class StockController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all()->sortByDesc('id');
        // $stocks = Stock::all();
        return view('admin.stock.index', compact('stocks'));
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
        return view('admin.stock.create', compact('products', 'isUpdate'));
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
        $product = $this->processStock($product, $proData);
        
        // Save price for this Product
        $product = $this->processPriceWithStockId($product, $proData);

        return redirect()->route('admin.stock.index');
    }

    public function stockDetails(Request $request){
        
        $pid = $request->id;
        $product = Product::where('id', $pid)->get()->first();
        $stocks = $product->stocks();

        return view('admin.stock.details', compact('product', 'stocks'));
    }

    public function createStockByDetails(int $id)
    {
        $isUpdate = true;
        $product = Product::find($id);

        return view('admin.stock.createByDetails', compact('product', 'isUpdate'));
    }


































    

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $stock = Stock::find($request->id);
        // $stock->delete();
        // return redirect()->route('admin.stock.index');
    }
}
