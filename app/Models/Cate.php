<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'cate_groups_id', 'description'];

    /**
     * Get the parent cateable model (Manufacture or CPU or ...)
     */
    public function cateable()
    {
        return $this->morphTo();
    }

    /**
     * Get the CateGroup that owns this Cate.
     */
    public function cate_group()
    {
        return $this->belongsTo(CateGroup::class, 'cate_groups_id');
    }
}
