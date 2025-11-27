<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price','stock','img', 'category', 'description'];
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'item_id');
    }
    public function getDescAttribute()
    {
        return $this->description;
    }

}
