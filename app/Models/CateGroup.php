<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateGroup extends Model
{
    use HasFactory;

    /**
     * Get the Cate Details for this CateGroup
     */
    public function cates()
    {
        return $this->hasMany(OrderDetail::class, 'cate_groups_id');
    }
}
