<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cates\Manufacture;
use App\Models\Cates\Cpu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Color;
use App\Models\Cates\Demand;
use App\Models\Cates\Gpu;
use App\Models\Cates\Resolution;
use App\Models\Cates\Series;
use App\Models\Stock;

class ProductController extends Controller
{

    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $products->load(
            'images',
            'manufacture',
            'cpu',
            'ram',
            'screen',
            'hdd',
            'ssd',
            'color',
            'gpu',
            'demand',
            'resolution'
        );
        return view('admin.product.index')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        $manufactures = Manufacture::all();
        $cpus = Cpu::all();
        $colors = Color::all();
        $gpus = Gpu::all();
        $demands = Demand::all();
        $series = collect([
            (object)[
                'id' => ' ',
                'name' => 'Please pick-up Manufacture first'
            ]
        ]);

        $resolutions = Resolution::all();
        $imageFiles = false;
        return view('admin.product.create')->with([
            'isUpdate' => $isUpdate,
            'manufactures' => $manufactures,
            'cpus' => $cpus,
            'colors' => $colors,
            'gpus' => $gpus,
            'demands' => $demands,
            'series' => $series,
            'resolutions' => $resolutions,
            'list_images' => $imageFiles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proData = $this->processData($request);

        // Save Ram
        $proData = $this->processRam($proData);

        // Save Screen
        $proData = $this->processScreen($proData);

        // Save HDD
        $proData = $this->processHdd($proData);

        // Save SSD
        $proData = $this->processSsd($proData);

        // Save Product
        $product = Product::create($proData);
        $product->refresh();

        // Save Price
        // $product = $this->processPrice($product, $proData);

        //Save Description
        $product = $this->processDescription($product, $proData);

        // Save Images
        $files = $this->processImage($request);
        if ($files === false) {
            return back()->with('errors', 'Only image file-type is accepted.');
        }
        if ($files !== null) {
            $product->images()->createMany($files);
        }

        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = Product::find($id);
        $imageFiles = $product->images()->exists() ? $product->images : false;
        $isUpdate = true;
        $manufactures = Manufacture::all();
        $cpus = Cpu::all();
        $colors = Color::all();
        $gpus = Gpu::all();
        $demands = Demand::all();
        $series = $product->manufacture->series;
        $resolutions = Resolution::all();
        return view('admin.product.create')->with([
            'product' => $product,
            'isUpdate' => $isUpdate,
            'manufactures' => $manufactures,
            'cpus' => $cpus,
            'colors' => $colors,
            'gpus' => $gpus,
            'demands' => $demands,
            'series' => $series,
            'resolutions' => $resolutions,
            'list_images' => $imageFiles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $proData = $this->processData($request);

        // Save Ram
        $proData = $this->processRam($proData);

        // Save Screen
        $proData = $this->processScreen($proData);

        // Save HDD
        $proData = $this->processHdd($proData);

        // Save SSD
        $proData = $this->processSsd($proData);

        // Save Product
        $product->update($proData);
        $product->refresh();

        // Save Price
        // $oldPrice = $product->price;
        // if ($proData['price'] != $oldPrice) {
        //     $product = $this->processPrice($product, $proData);
        // }

        //Save Description
        $product = $this->processDescription($product, $proData);

        // Save Images
        $files = $this->processImage($request);
        if ($files === false) {
            return back()->with('errors', 'Only image file-type is accepted.');
        }
        $images = $product->images;
        if (count($images) > 0) {
            $this->removeItems($images, $proData);
        }
        if ($files !== null) {
            $product->images()->createMany($files);
        }

        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->id);
        // $product->prices()->delete();
        // $product->order_details()->delete();
        $images = $product->images;
        if (count($images) > 0) {
            foreach ($images as $image) {
                File::delete(public_path("images/" . $image->url));
                $image->delete();
            }
        }
        $product->delete();
        return redirect()->route('admin.product.index');
    }
}
