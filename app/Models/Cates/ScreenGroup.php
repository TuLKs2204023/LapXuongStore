<?php

namespace App\Models\Cates;

use App\Http\Traits\ProcessModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenGroup extends Model
{
    use HasFactory;
    use ProcessModelData;

    protected $fillable = ['name', 'slug', 'description', 'value', 'min', 'max'];

    /**
     * Get the ScreenGroup's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the screens for the ScreenGroup.
     * 
     * @param  void
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function cateItems()
    {
        return $this->processCates($this, 'Screen');
    }
}
