<?php

namespace App\Http\Traits;

use App\Models\Product;
use App\Models\Cates\Ram;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        $stock = DB::table('stocks')->where('product_id', $product->id)->get()->last();

        $product->prices()->create(['origin' => $proData['price'], 'stock_id' => $stock->id]);
        $product->push();
        return $product;
    }


    function processStock(Product $product, array $proData){
        //Tú tạo

        $product->stocks()->create(['in_qty' => $proData['in_qty'] ]);
        $product->refresh();
        return $product;
    }
    
    function processRam(array $proData)
    {
        $ram = Ram::firstOrCreate(['amount' => $proData['ram']]);
        $ram->refresh();
        $proData['ram_id'] = $ram->id;
        return $proData;

    }

    function processImage(Request $request)
    {
        $files = [];
        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $file) {
                if (!exif_imagetype($file)) {
                    return false;
                }
                $ext = $file->getClientOriginalExtension();
                // if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
                //     return back()->with('error', 'Only extension ... accepted.');
                // }
                $fileName = time() . rand(1, 10000) . '.' . $ext;
                $file->move(public_path('images'), $fileName);
                $files[] = ['url' => $fileName];
            }
            return $files;
        } else {
            return null;
        }
    }

    // Use jointly with processImage()
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

    /**
     * Get the rams for the RamGroup.
     * 
     * @param  \Illuminate\Database\Eloquent\Model $groupModel
     * @param  string $subClass
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function processCates($groupModel, $subClass)
    {
        $groupData = $groupModel->toArray();

        $subModel = 'App\Models\Cates\\' . $subClass;

        $cateCases = [
            $this->isExactVal($groupData) => function ($query) use ($groupData) {
                return $query->where('amount', $groupData['value']);
            },
            $this->isMinVal($groupData) => function ($query) use ($groupData) {
                return $query->where('amount', '>=', $groupData['min']);
            },
            $this->isMaxVal($groupData) => function ($query) use ($groupData) {
                return $query->where('amount', '<=', $groupData['max']);
            },
            $this->isRangeVal($groupData) => function ($query) use ($groupData) {
                return $query->where([
                    ['amount', '>=', $groupData['min']],
                    ['amount', '<=', $groupData['max']]
                ]);
            },
        ];

        foreach ($cateCases as $key => $case) {
            if ($key) {
                return $subModel::where(function (Builder $query) use ($case) {
                    return $case($query);
                })->get();
            }
        }
    }

    /**
     * Supporting function for processCate()
     * 
     */
    private function isExactVal(array $proData): bool
    {
        if ($proData['value'] != 0 && !empty($proData['value'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Supporting function for processCate()
     * 
     */
    private function isMinVal(array $proData): bool
    {
        if ($proData['min'] != 0 && !empty($proData['min'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Supporting function for processCate()
     * 
     */
    private function isMaxVal(array $proData): bool
    {
        if ($proData['max'] != 0 && !empty($proData['max'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Supporting function for processCate()
     * 
     */
    private function isRangeVal(array $proData): bool
    {
        if ($proData['min'] != 0 && !empty($proData['min']) && $proData['max'] != 0 && !empty($proData['max'])) {
            return true;
        } else {
            return false;
        }
    }
}
