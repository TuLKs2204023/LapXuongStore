<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;


    protected $fillable=[
        'name',
        'city_id'
    ];
    public function users(){
        return $this->hasMany(User::class);
    }
}
