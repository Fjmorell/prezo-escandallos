<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PrezoService
{
    public function getRecipeCost(Recipe $recipe): float
    {
        $cost = 0;

        foreach ($recipe->items as $item) {
            if ($item->product) {
                $cost += $item->product->cost * $item->quantity;
            } elseif ($item->childRecipe) {
                $cost += $this->getRecipeCost($item->childRecipe) * $item->quantity;
            }
        }

        return round($cost, 2);
    }

    public function getRecipeMargin(Recipe $recipe): float
    {
        $cost = $this->getRecipeCost($recipe);
        if ($cost == 0 || $recipe->price == 0) return 0;
    
        $margin = (($recipe->price - $cost) / $recipe->price) * 100;
        return number_format($margin, 2, '.', '');
    }
    
    public function getSalesVolume(): array
{
    $recipes = Recipe::with('items.product', 'items.childRecipe', 'saleLines')->get();

$result = [];

foreach ($recipes as $recipe) {
    $totalQty = $recipe->saleLines->sum('quantity');
    if ($totalQty === 0) continue; 

    $cost = $this->getRecipeCost($recipe);
    $margin = $this->getRecipeMargin($recipe);
    $totalRevenue = $totalQty * $recipe->price;

    $result[] = [
        'name' => $recipe->name,
        'unit_cost' => $cost,
        'price' => $recipe->price,
        'margin' => $margin,
        'total_quantity_sold' => $totalQty,
        'total_revenue' => round($totalRevenue, 2),
    ];
}


    $maxCost = collect($result)->sortByDesc('unit_cost')->first();
$minCost = collect($result)->sortBy('unit_cost')->first();

$maxMargin = collect($result)->sortByDesc('margin')->first();
$minMargin = collect($result)
    ->filter(fn($r) => $r['total_quantity_sold'] > 0)
    ->sortBy('margin')
    ->first();

return [
    'recipes' => $result,
    'max_cost' => $maxCost,
    'min_cost' => $minCost,
    'max_margin' => $maxMargin,
    'min_margin' => $minMargin,
];

}
public function getDailySalesSummary(): array
{
    return DB::table('sale_lines')
        ->join('sales', 'sale_lines.sale_id', '=', 'sales.id')
        ->join('recipes', 'sale_lines.recipe_id', '=', 'recipes.id')
        ->selectRaw('DATE(sales.created_at) as date')
        ->selectRaw('SUM(sale_lines.quantity) as total_units')
        ->selectRaw('SUM(sale_lines.quantity * recipes.price) as total_revenue')
        ->groupByRaw('DATE(sales.created_at)')
        ->orderBy('date')
        ->get()
        ->map(function ($row) {
            return [
                'date' => Carbon::parse($row->date)->format('Y-m-d'),
                'total_units' => $row->total_units,
                'total_revenue' => round($row->total_revenue, 2),
            ];
        })
        ->toArray();
}

public function getBestAndWorstSalesDay(): array
{
    $dailySales = $this->getDailySalesSummary();

    if (empty($dailySales)) {
        return [
            'max' => null,
            'min' => null,
        ];
    }

    $max = collect($dailySales)->sortByDesc('total_revenue')->first();
    $min = collect($dailySales)->sortBy('total_revenue')->first();

    return [
        'max' => $max,
        'min' => $min,
    ];
}


}
