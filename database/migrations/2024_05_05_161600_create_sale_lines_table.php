<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sale_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('recipe_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->integer('quantity'); // Unidades vendidas
            $table->decimal('price', 8, 2)->nullable(); // Precio de venta (opcional)

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sale_lines');
    }
};
