<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PrezoService;

class RunPrezoCommand extends Command
{
    protected $signature = 'prezo:run';
    protected $description = 'Calcula escandallos y ventas';

    protected PrezoService $prezoService;

    public function __construct(PrezoService $prezoService)
    {
        parent::__construct();
        $this->prezoService = $prezoService;
    }

    public function handle()
    {
        $data = $this->prezoService->getSalesVolume();
        $rows = $data['recipes'];
    
        $this->table(
            ['Receta', 'Costo Unitario', 'Precio Venta', 'Margen (%)', 'Vendidos', 'Total Ventas ($)'],
            array_map(function ($r) {
                return [
                    $r['name'],
                    $r['unit_cost'],
                    $r['price'],
                    $r['margin'],
                    $r['total_quantity_sold'],
                    $r['total_revenue']
                ];
            }, $rows)
        );
    
        $this->info("\n📊 Receta con mayor coste: {$data['max_cost']['name']}, {$data['max_cost']['unit_cost']}");
        $this->info("📉 Receta con menor coste: {$data['min_cost']['name']}, {$data['min_cost']['unit_cost']}");
        $this->info("💰 Receta con mayor margen: {$data['max_margin']['name']}, {$data['max_margin']['margin']}%");
        $this->info("📉 Receta con menor margen: {$data['min_margin']['name']}, {$data['min_margin']['margin']}%");
    
        $this->info("\n📅 Volumen de ventas por día:\n");
    
        $dailySummary = $this->prezoService->getDailySalesSummary();
    
        $this->table(
            ['Fecha', 'Total Unidades Vendidas', 'Total Ingresos ($)'],
            array_map(function ($day) {
                return [
                    $day['date'],
                    $day['total_units'],
                    $day['total_revenue'],
                ];
            }, $dailySummary)
        );
        $bestAndWorst = $this->prezoService->getBestAndWorstSalesDay();

if ($bestAndWorst['max']) {
    $this->info("📈 Día con mayor volumen de ventas: {$bestAndWorst['max']['date']}, {$bestAndWorst['max']['total_revenue']}");
}

if ($bestAndWorst['min']) {
    $this->info("📉 Día con menor volumen de ventas: {$bestAndWorst['min']['date']}, {$bestAndWorst['min']['total_revenue']}");
}

$this->info("\nMargen de beneficio de cada escandallo:");
foreach ($rows as $row) {
    $marginFormatted = number_format($row['margin'], 2, '.', '');
    $this->info("- {$row['name']}: {$marginFormatted}%");
}


    }
    
}
