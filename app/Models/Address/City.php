<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;



    protected $fillable=[
        'name'

    ];
    public function users(){
        return $this->hasMany(User::class);
    }
}
