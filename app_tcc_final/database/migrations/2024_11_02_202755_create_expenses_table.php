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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade'); // Fazenda associada
            $table->string('item'); // Tipo de item, como "remédio", "sal", etc.
            $table->decimal('cost', 10, 2); // Custo total da despesa
            $table->integer('quantity')->nullable(); // Quantidade do item (opcional)
            $table->date('expense_date'); // Data da despesa
            $table->text('notes')->nullable(); // Observações adicionais
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
