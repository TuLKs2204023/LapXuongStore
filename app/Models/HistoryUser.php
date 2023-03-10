<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
    
        'data',
        'action',

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
