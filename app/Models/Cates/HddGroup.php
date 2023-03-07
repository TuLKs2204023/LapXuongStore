<?php

namespace App\Models\Cates;

use App\Http\Traits\ProcessModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HddGroup extends Model
{
    use HasFactory;
    use ProcessModelData;

    protected $fillable = ['name', 'slug', 'description', 'value', 'min', 'max'];

    /**
     * Get the RamGroup's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the rams for the RamGroup.
     * 
     * @param  void
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function cateItems()
    {
        return $this->processCates($this, 'Hdd');
    }
}
