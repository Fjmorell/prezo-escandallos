<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'price'];

    public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function saleLines()
    {
        return $this->hasMany(SaleLine::class);
    }
}
