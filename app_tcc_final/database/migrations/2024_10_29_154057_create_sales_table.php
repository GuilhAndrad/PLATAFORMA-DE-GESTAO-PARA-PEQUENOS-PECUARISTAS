<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade'); // Fazenda de venda
            $table->string('buyer'); // Comprador
            $table->unsignedInteger('animal_quantity'); // Quantidade de animais
            $table->decimal('weight_per_animal', 8, 2); // Peso por animal em kg
            $table->decimal('price', 10, 2);
            $table->date('sale_date'); // Data da venda
            $table->boolean('is_paid')->default(false); // Status de pagamento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
