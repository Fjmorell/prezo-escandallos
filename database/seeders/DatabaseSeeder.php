<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\RecipeItem;
use App\Models\Sale;
use App\Models\SaleLine;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Productos
        $aguacate = Product::create(['name' => 'Aguacate', 'cost' => 1.00]);
        $cebolla  = Product::create(['name' => 'Cebolla', 'cost' => 1.00]);
        $tomate   = Product::create(['name' => 'Tomate', 'cost' => 1.00]);
        $limon    = Product::create(['name' => 'Limón', 'cost' => 1.00]);
        $sal      = Product::create(['name' => 'Sal', 'cost' => 1.00]);
        $totopos  = Product::create(['name' => 'Totopos', 'cost' => 1.00]);
        $ron      = Product::create(['name' => 'Ron', 'cost' => 2.00]);
        $cocacola = Product::create(['name' => 'Coca Cola', 'cost' => 1.00]);

        // Guacamole
        $guacamole = Recipe::create(['name' => 'Guacamole', 'price' => 4.51]);
        RecipeItem::create(['recipe_id' => $guacamole->id, 'product_id' => $aguacate->id, 'quantity' => 2]);
        RecipeItem::create(['recipe_id' => $guacamole->id, 'product_id' => $cebolla->id, 'quantity' => 1]);
        RecipeItem::create(['recipe_id' => $guacamole->id, 'product_id' => $tomate->id, 'quantity' => 1]);
        RecipeItem::create(['recipe_id' => $guacamole->id, 'product_id' => $limon->id, 'quantity' => 0.5]);
        RecipeItem::create(['recipe_id' => $guacamole->id, 'product_id' => $sal->id, 'quantity' => 0.01]);

        // Nachos con guacamole
        $nachos = Recipe::create(['name' => 'Nachos con guacamole', 'price' => 10.00]);
        RecipeItem::create(['recipe_id' => $nachos->id, 'product_id' => $totopos->id, 'quantity' => 1]);
        RecipeItem::create(['recipe_id' => $nachos->id, 'child_recipe_id' => $guacamole->id, 'quantity' => 1]);

        // Ron Cola
        $ronCola = Recipe::create(['name' => 'Ron Cola', 'price' => 8.00]);
        RecipeItem::create(['recipe_id' => $ronCola->id, 'product_id' => $ron->id, 'quantity' => 1]);
        RecipeItem::create(['recipe_id' => $ronCola->id, 'product_id' => $cocacola->id, 'quantity' => 0.5]);

        
        $sale1 = Sale::create(['date' => '2024-07-02', 'created_at' => '2024-07-02']);
        SaleLine::create(['sale_id' => $sale1->id, 'recipe_id' => $nachos->id, 'quantity' => 10]);

        $sale2 = Sale::create(['date' => '2024-07-02', 'created_at' => '2024-07-02']);
        SaleLine::create(['sale_id' => $sale2->id, 'recipe_id' => $ronCola->id, 'quantity' => 5]);
        SaleLine::create(['sale_id' => $sale2->id, 'recipe_id' => $nachos->id, 'quantity' => 10]);

        $sale3 = Sale::create(['date' => '2024-07-03', 'created_at' => '2024-07-03']);
        SaleLine::create(['sale_id' => $sale3->id, 'recipe_id' => $ronCola->id, 'quantity' => 8]);

        $sale4 = Sale::create(['date' => '2024-07-03', 'created_at' => '2024-07-03']);
        SaleLine::create(['sale_id' => $sale4->id, 'recipe_id' => $ronCola->id, 'quantity' => 2]);
        SaleLine::create(['sale_id' => $sale4->id, 'recipe_id' => $nachos->id, 'quantity' => 3]);
    }
}
