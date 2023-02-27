<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    protected $table = 'specification';
    protected $primarykey = 'id';
    protected $guarded = [];

    public function product(){
        return $this->hasMany(Product::class,'manufacture_id','id');
    }
}
