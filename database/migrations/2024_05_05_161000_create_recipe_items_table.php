<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('recipe_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('child_recipe_id')
                  ->nullable()
                  ->constrained('recipes') 
                  ->onDelete('cascade');

            $table->decimal('quantity', 8, 2);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('recipe_items');
    }
};
