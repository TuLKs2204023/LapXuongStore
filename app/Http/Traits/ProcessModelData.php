<?php

namespace App\Http\Traits;

use App\Models\Cates\Hdd;
use App\Models\Product;
use App\Models\Cates\Ram;
use App\Models\Cates\Screen;
use App\Models\Cates\Ssd;
use App\Models\Order;
use App\Models\User;
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
        // From 'TU Lele' with ❤❤❤
        $proData = $request->all();
        return $proData;
    }

    // function processPrice(Product $product, array $proData){
    //     $product->prices()->create(['origin' => $proData['price']]);
    //     $product->refresh();
    //     return $product;
    // }

    function processPriceWithStockId(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $stock = DB::table('stocks')->where('product_id', $product->id)->get()->last();

        $product->prices()->create(['origin' => $proData['price'], 'stock_id' => $stock->id]);
        $product->push();
        return $product;
    }

    function processDescription(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $product->description()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'weight' => $proData['weight'],
                'dimension' => $proData['dimension'],
                'webcam' => $proData['webcam'],
                'o_s' => $proData['o_s'],
                'battery' => $proData['battery'],
                'warranty' => $proData['warranty'],
                'instruction' => $proData['instruction'],
                'feature' => $proData['feature'],
            ]
        );
        $product->refresh();
        return $product;
    }

    function processInStock(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $product->stocks()->create(['in_qty' => $proData['in_qty']]);
        $product->refresh();
        return $product;
    }

    function processOutStock(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $product->stocks()->create(['out_qty' => $proData['out_qty']]);
        $product->refresh();
        return $product;
    }

    function processUsedPromotion(Order $order, string $promotionCode)
    {
        // From 'TU Lele' with ❤❤❤
        $promotionId = DB::table('promotions')->where('code', $promotionCode)->first();

        $order->usedPromotion()->create(['promotion_id' => $promotionId]);
        $order->refresh();
        return $order;
    }

    function processRating(User $user, array $proData){
        //Tú tạo
        $product = DB::table('products')->where('id', $proData['product_id'])->first();

        $productId = $product->id;

        $user->ratings()->create(['rate' => $proData['selected_rating'], 'review' => $proData['review'], 'product_id' => $productId]);
        $user->refresh();
    }
    
    function processRam(array $proData)
    {
        $ram = Ram::firstOrCreate(['amount' => $proData['ram']]);
        $ram->refresh();
        $proData['ram_id'] = $ram->id;
        return $proData;
    }

    function processScreen(array $proData)
    {
        $screen = Screen::firstOrCreate(['amount' => $proData['screen']]);
        $screen->refresh();
        $proData['screen_id'] = $screen->id;
        return $proData;
    }

    function processHdd(array $proData)
    {
        $hdd = Hdd::firstOrCreate(['amount' => $proData['hdd']]);
        $hdd->refresh();
        $proData['hdd_id'] = $hdd->id;
        return $proData;
    }

    function processSsd(array $proData)
    {
        $ssd = Ssd::firstOrCreate(['amount' => $proData['ssd']]);
        $ssd->refresh();
        $proData['ssd_id'] = $ssd->id;
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

    /**
     * Remove selected items, used jointly with processImage()
     * 
     */
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
     * Get the sub-items for the corresponding Group model.
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
