<?php

namespace App\Models;

use App\Http\Traits\ProcessModelData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class HistoryUser extends Model
{
    use ProcessModelData;
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'by',
        'data',
        'action',

    ];
    public function time()
    {
        $now = Carbon::now();
        $duration = $this->duration($now, $this->created_at);
        return $duration;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
