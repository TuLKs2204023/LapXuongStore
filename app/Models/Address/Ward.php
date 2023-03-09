<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'district_id'
    ];
    public function users(){
        return $this->hasMany(User::class);
    }
}
