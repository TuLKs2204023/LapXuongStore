<?php

namespace App\Http\Traits;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait ProcessModelData
{

    function processData(Request $request)
    {
        $proData = $request->all();
        $proData['slug'] = Str::slug($request->name);
        return $proData;
    }

    function processDataWithOutSlug(Request $request)
    {
        //Tú tạo
        $proData = $request->all();
        return $proData;
    }
    
    function processPrice(Product $product, array $proData)
    {
        $product->prices()->create(['origin' => $proData['price']]);
        $product->refresh();
        return $product;
    }

    function processStock(Product $product, array $proData){
        //Tú tạo
        $product->stocks()->create(['in_qty' => $proData['in_qty']]);
        $product->refresh();
        return $product;
    }

    function processImage(Request $request)
    {
        $files = [];
        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $file) {
                $ext = $file->getClientOriginalExtension();
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
                    return back()->with('error', 'Only extension ... accepted.');
                }
                $fileName = time() . rand(1, 10000) . '.' . $ext;
                $file->move(public_path('images'), $fileName);
                $files[] = ['url' => $fileName];
            }
            return $files;
        } else {
            return false;
        }
    }

    function removeItems($images, $proData)
    {
        $filesRemove = [];
        $filesOrigin = [];
        foreach ($images as $image) {
            $filesOrigin[] = $image->url;
        }

        if (isset($proData['images_edited'])) {
            $filesRemove = array_diff($filesOrigin, $proData['images_edited']);
        } else {
            $filesRemove = &$filesOrigin;
        }

        foreach ($images as $image) {
            if (in_array($image->url, $filesRemove)) {
                File::delete(public_path("images/" . $image->url));
                $image->delete();
            }
        }
    }
}
