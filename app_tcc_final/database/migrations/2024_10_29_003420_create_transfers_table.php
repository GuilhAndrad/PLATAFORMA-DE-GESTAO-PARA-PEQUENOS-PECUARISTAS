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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_farm_id')->constrained('farms')->onDelete('cascade'); // Fazenda de origem
            $table->foreignId('destination_farm_id')->constrained('farms')->onDelete('cascade'); // Fazenda de destino
            $table->unsignedInteger('animal_quantity'); // Quantidade de animais a transferir
            $table->date('transfer_date'); // Data da transferência
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
