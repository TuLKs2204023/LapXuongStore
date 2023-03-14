<?php

namespace App\Http\Traits;

use App\Mail\OrderConfirmation;
use App\Models\Cates\Hdd;
use App\Models\Product;
use App\Models\Cates\Ram;
use App\Models\Cates\Screen;
use App\Models\Cates\Ssd;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    function processPriceInStock(Product $product, array $proData)
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

    function completeOrder(Order $order)
    {
        Mail::to($order->email)->send(new OrderConfirmation($order));
    }

    function processOutStock(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $stock = $product->stocks()->create(['out_qty' => $proData['out_qty']]);
        $product->prices()->create([
            'sale' => $product->salePrice(),
            'discount' => $product->latestDiscount(),
            'stock_id' => $stock->id,
        ]);
        $product->refresh();
        return $stock;
    }

    function processUsedPromotion(Order $order, string $promotionCode)
    {
        // From 'TU Lele' with ❤❤❤
        $promotionId = DB::table('promotions')->where('code', $promotionCode)->first();

        $order->usedPromotion()->create(['promotion_id' => $promotionId]);
        $order->refresh();
        return $order;
    }

    function processRating(User $user, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $product = DB::table('products')->where('id', $proData['product_id'])->first();

        $productId = $product->id;

        $user->ratings()->create(['rate' => $proData['selected_rating'], 'review' => $proData['review'], 'product_id' => $productId]);
        $user->refresh();
    }

    function processDiscount(Product $product, array $proData)
    {
        // From 'TU Lele' with ❤❤❤
        $proData['amount'] = $proData['amount'] / 100;
        $product->discounts()->create(['amount' => $proData['amount']]);
        $product->refresh();
        return $product;
    }

    function processRam(array $proData)
    {
        if ($proData['ram_select'] == 2) {
            $proData['ram'] = $proData['ram'] * 1024;
        }
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
        if ($proData['hdd_select'] == 2) {
            $proData['hdd'] = $proData['hdd'] * 1024;
        }
        $hdd = Hdd::firstOrCreate(['amount' => $proData['hdd']]);
        $hdd->refresh();
        $proData['hdd_id'] = $hdd->id;
        return $proData;
    }

    function processSsd(array $proData)
    {
        if ($proData['ssd_select'] == 2) {
            $proData['ssd'] = $proData['ssd'] * 1024;
        }
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
     * Processing Input data for saving Cate model.
     * 
     * @param  \Illuminate\Database\Eloquent\Model $cate
     * @param  integer $groupId
     * 
     * @return array $cateItm
     */
    function processCate($cate, $groupId)
    {
        $cateData['name'] = $cate->name;
        $cateData['slug'] = Str::slug($cate->name);
        $cateData['cate_groups_id'] = $groupId;
        return $cateData;
    }
    /**
     * Processing cate-Name for saving Cate model
     * 
     * @param  array $proData
     * @param  string $cateText
     * 
     * @return array $proData
     */
    function processCateName($proData, $cateText)
    {
        if ($this->isExactVal($proData)) {
            $proData['name'] = $proData['value'] . $cateText;
        }
        if ($this->isMinVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . $cateText;
        }
        if ($this->isMaxVal($proData)) {
            $proData['name'] = 'To ' . $proData['max'] . $cateText;
        }
        if ($this->isRangeVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . $cateText . ' to ' . $proData['max'] . $cateText;
        }

        $proData['slug'] = Str::slug($proData['name']);
        return $proData;
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
        if (!isset($proData['value'])) {
            return false;
        }
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
        if (!isset($proData['min'])) {
            return false;
        }
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
        if (!isset($proData['max'])) {
            return false;
        }
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
        if (!isset($proData['min']) or !isset($proData['max'])) {
            return false;
        }
        if ($proData['min'] != 0 && !empty($proData['min']) && $proData['max'] != 0 && !empty($proData['max'])) {
            return true;
        } else {
            return false;
        }
    }


    /* A function to update history user' table. */
    public function data($user, array $data)
    {
        $final = "";
        $old_name = $user->name;
        $old_phone = $user->phone;
        $old_address = $user->address;
        $old_gender = $user->gender;
        $old_city = $user->city_id;
        $old_district = $user->district_id;
        $old_ward = $user->ward_id;
        if ($data['name'] != $old_name) {
            $name = $old_name ?? 'Not Updated';
            $final = $final . 'Name: ' . $name . ' to ' . $data['name']  . ', ';
        }
        if ($data['phone'] != $old_phone) {
            $phone = $old_phone ?? 'Not Updated';
            $final = $final  . 'Phone: ' . $phone . ' to ' . $data['phone']  . ', ';
        }

        if ($data['gender'] != $old_gender) {
            $gender = $old_gender ?? 'Not Updated';
            $final = $final  . 'Gender: ' . $gender . ' to ' . $data['gender']  . ', ';
        }

        if ($data['city_id'] != $old_city) {
            $city = DB::table('cities')->where('id', $data['city_id'])->first()->name;
            $oldCity = auth()->user()->city->name ?? '';
            $final = $final  . 'City: ' . $oldCity . ' to ' . $city . ', ';
        }
        if ($data['district_id'] != $old_district) {
            $oldDistrict = auth()->user()->district->name ?? '';
            $district = DB::table('districts')->where('id', $data['district_id'])->first()->name;
            $final = $final  . 'District: ' . $oldDistrict . ' to ' . $district . ', ';
        }
        if ($data['ward_id'] != $old_ward) {
            $oldWard = auth()->user()->ward->name ?? '';
            $ward = DB::table('wards')->where('id', $data['ward_id'])->first()->name;
            $final = $final  . 'Ward: ' . $oldWard . ' to ' . $ward . ',';
        }
        if ($data['address'] != $old_address) {
            $address = $old_address ?? 'Not Updated';
            $final = $final  . 'Address: ' . $address . ' to ' . $data['address']  . '. ';
        }

        $user->histories()->create(['data' => $final, 'action' => 'Updated']);
    }

    public function adminData($user, array $data)
    {
        $final = "";
        $old_name = $user->name;
        $old_phone = $user->phone;
        $old_address = $user->address;
        $old_gender = $user->gender;
        $old_role = $user->role;

        if ($data['name'] != $old_name) {
            $name = $old_name ?? 'Not Updated';
            $final = $final . 'Name: ' . $name . ' to ' . $data['name']  . ', ';
        }
        if ($data['phone'] != $old_phone) {
            $phone = $old_phone ?? 'Not Updated';
            $final = $final  . 'Phone: ' . $phone . ' to ' . $data['phone']  . ', ';
        }
        if ($data['address'] != $old_address) {
            $address = $old_address ?? 'Not Updated';
            $final = $final  . 'Address: ' . $address . ' to ' . $data['address']  . ', ';
        }
        if ($data['gender'] != $old_gender) {
            $gender = $old_gender ?? 'Not Updated';
            $final = $final  . 'Gender: ' . $gender . ' to ' . $data['gender']  . ', ';
        }
        if ($data['role'] != $old_role) {
            $role = $old_role ?? 'Not Updated';
            $final = $final  . 'Role: ' . $role . ' to ' . $data['role']  . '. ';
        }



        $user->histories()->create(['data' => $final, 'action' => 'Updated', 'by' => 'by Admin']);
    }


    // ===================================================Count time===================================================
    private function year($now, $keytime)
    {
        $duration = 0;
        if ($now->year != $keytime->year) {
            $duration = $now->year - $keytime->year;
            if ($duration > 1) {
                return $duration . ' years ago';
            } else {
                return $duration . ' year ago';
            }
        } else {
            return $duration;
        }
    }
    private function month($now, $keytime)
    {
        $duration = 0;
        if ($now->month != $keytime->month) {
            $duration = $now->month - $keytime->month;
            if ($duration > 1) {
                return $duration . ' months ago';
            } else {
                return $duration . ' month ago';
            }
        } else {
            return $duration;
        }
    }
    private function day($now, $keytime)
    {
        $duration = 0;
        if ($now->day != $keytime->day) {
            $duration = $now->day - $keytime->day;
            if ($duration > 1) {
                return $duration . ' days ago';
            } else {
                return $duration . ' day ago';
            }
        } else {
            return $duration;
        }
    }
    private function hour($now, $keytime)
    {
        $duration = 0;
        if ($now->hour != $keytime->hour) {
            $duration = $now->hour - $keytime->hour;
            if ($duration > 1) {
                return $duration . ' hours ago';
            } else {
                return $duration . ' hour ago';
            }
        } else {
            return $duration;
        }
    }
    private function minute($now, $keytime)
    {
        $duration = 0;
        if ($now->minute != $keytime->minute) {
            $duration = $now->minute - $keytime->minute;
            if ($duration > 1) {
                return $duration . ' minutes ago';
            } else {
                return $duration . ' minute ago';
            }
        } else {

            return $duration = 'Just now';
        }
    }

    public function duration($now, $keytime)
    {
        $duration = $this->year($now, $keytime);
        if ($duration == 0) {
            $duration = $this->month($now, $keytime);
        }
        if ($duration == 0) {
            $duration = $this->day($now, $keytime);
        }
        if ($duration == 0) {
            $duration = $this->hour($now, $keytime);
        }
        if ($duration == 0) {
            $duration = $this->minute($now, $keytime);
        }
        return $duration;
    }
    // ===================================================end Count time===================================================

}
