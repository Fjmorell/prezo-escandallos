<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    protected $fillable = [
        'recipe_id',
        'product_id',
        'child_recipe_id',
        'quantity'
    ];

    // Relación con receta que contiene este item
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    // Si el item es un producto (ingrediente base)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Si el item es una sub-receta
    public function childRecipe()
    {
        return $this->belongsTo(Recipe::class, 'child_recipe_id');
    }
}
