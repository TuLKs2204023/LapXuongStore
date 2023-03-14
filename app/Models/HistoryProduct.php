<?php

namespace App\Models;

use App\Http\Traits\ProcessModelData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProduct extends Model
{
    use ProcessModelData;
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'data',
        'fulldata',
        'action',

    ];
    public function timePro()
    {
        $now = Carbon::now();
        $durationPro = $this->duration($now, $this->created_at);
        return $durationPro;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
