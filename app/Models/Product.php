<?php

namespace App\Models;

use App\Models\Cates\Manufacture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'manufacture_id',
        'series_id',
        'cpu_id',
        'gpu_id',
        'ram_id',
        'color_id',
        'demand_id',
        'resolution_id',
        'screen_id',
        'hdd_id',
        'ssd_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['price', 'price_id'];


    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['prices', 'latestPrice'];

    /**
     * Get the product's price attribute.
     */
    public function getPriceAttribute()
    {
        return $this->latestPrice->origin ?? 0;
    }
    /**
     * Get the product's price_id attribute.
     */
    public function getPriceIdAttribute()
    {
        return $this->latestPrice->id ?? 0;
    }

    /**
     * Get the Prices for product
     */
    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id');
    }


    /**
     * Get the current pricing for the product.
     */
    public function currentPrice()
    {
        return $this->hasOne(Price::class)->ofMany([
            'published_at' => 'max',
            'id' => 'max',
        ], function ($query) {
            $query->where('published_at', '<', now());
        });
    }

    /**
     * Get the product's most recent price.
     */
    public function latestPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany();
    }

    /**
     * Get the product's oldest price.
     */
    public function oldestPrice()
    {
        return $this->hasOne(Price::class)->oldestOfMany();
    }

    /**
     * Get the Order Details for product
     */
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    /**
     * Get all of the product's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get the product's most recent image.
     */
    public function latestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }

    /**
     * Get the product's oldest image.
     */
    public function oldestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }

    /**
     * Get the manufacture that owns this product.
     */
    public function manufacture()
    {
        return $this->belongsTo(Cates\Manufacture::class, 'manufacture_id');
    }

    /**
     * Get the cpu that owns this product.
     */
    public function cpu()
    {
        return $this->belongsTo(Cates\Cpu::class, 'cpu_id');
    }

    /**
     * Get the stocks that belongs to this product.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /* Get latest stock this product.
     */

    public function latestStock()
    {
        return $this->hasMany(Stock::class)->latestOfMany();
    }

    /* Get amount of in stock this product.
     */

    public function inStock()
    {
        $in_qty = 0;
        $in_qty = DB::table('stocks')
            ->where('product_id', $this->id)
            ->sum('in_qty');
        return $in_qty;
    }

    /* Get amount of out stock this product.
     */

    public function outStock()
    {
        $out_qty = 0;
        $out_qty = DB::table('stocks')
            ->where('product_id', $this->id)
            ->sum('out_qty');
        return $out_qty;
    }
    /* Get the RAM that owns this product.
     */
    public function ram()
    {
        return $this->belongsTo(Cates\Ram::class, 'ram_id');
    }

    /* Get the Screen that owns this product.
     */
    public function screen()
    {
        return $this->belongsTo(Cates\Screen::class, 'screen_id');
    }

    /* Get the HDD that owns this product.
     */
    public function hdd()
    {
        return $this->belongsTo(Cates\Hdd::class, 'hdd_id');
    }

    /* Get the color that owns this product.
     */
    public function color()
    {
        return $this->belongsTo(Cates\Color::class, 'color_id');
    }

    /* Get the gpu that owns this product.
     */
    public function gpu()
    {
        return $this->belongsTo(Cates\Gpu::class, 'gpu_id');
    }

    /* Get the SSD that owns this product.
     */
    public function ssd()
    {
        return $this->belongsTo(Cates\Ssd::class, 'ssd_id');
    }

    /* Get the Demand that owns this product.
     */
    public function demand()
    {
        return
            $this->belongsTo(Cates\Demand::class, 'demand_id');
    }
    /* Get the Demand that owns this product.
     */
    public function series()
    {
        return $this->belongsTo(Cates\Series::class, 'series_id');
    }

    /* Get the Demand that owns this product.
     */
    public function resolution()
    {
        return $this->belongsTo(Cates\Resolution::class, 'resolution_id');
    }

    /* Get the sub name of this product.
     */

    public function subName()
    {
        $name = $this->name;
        $splitName = [];
        $splitName = (explode('(', $name)); //trả về array
        $subName = $splitName[0];
        return $subName;
    }

    /* Get description of this product.
     */

    public function description()
    {
        return $this->hasOne(Description::class);
    }

    /* -------------------------------Rate---------------------------------
     */

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function countRates()
    {
        $rates = 0;
        $rates = $this->loadCount('ratings');
        $countRates = $rates->ratings_count;

        // $total = $this->ratings;
        return $countRates;
    }

    public function sumRates()
    {
        $rates = 0;
        $rates = $this->loadSum('ratings', 'rate');
        $sumRates = $rates->ratings_sum_rate;

        return $sumRates;
    }

    public function avgRates()
    {
        $avg = 0;
        $avg = $this->sumRates() / $this->countRates();
        return number_format($avg, 0, '.');
    }

    /* -------------------------------end Rate---------------------------------
     */

    /* -------------------------------Wishlist_Item---------------------------------
     */

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function findWishlist()
    {
        $user = auth()->user();
        if ($user) {
            $userId = $user->id;
            $wishlistItems = $this->wishlistItems();
            $found = $wishlistItems->where('user_id', $userId)->first();
            if ($found) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /* -------------------------------end Wishlist_Item---------------------------------
     */

    public function relateProducts()
    {
        $relates = Product::where('manufacture_id', $this->manufacture_id)->get();
        return $relates;
    }
    public function salePrice()
    {
        $id = $this->id;
        $price = DB::table('prices')->where('product_id', $id)->avg('origin');
        $saleprice = $price + $price * 50 / 100;

        return $saleprice;
    }
    public function fakePrice()
    {
        return $this->salePrice() * 120 / 100;
    }
    public function revenue()
    {
        $outStock = $this->outStock();
        $price = $this->salePrice();
        $revenue = $outStock * $price;
        return $revenue;
    }
    public function topSale()
    {
        $count = DB::table('products')->count('id');
        DB::table('products')->get()->first()->id;
        $max = $this->outStock();
        for ($i = 1; $i < $count; $i++) {
            if ($max > $this->outStock()) {
                $max = $this->outStock();
            }
        }
        return $max;
    }
}
