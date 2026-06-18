<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('echeances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financements_id')->constrained('financements')->onDelete('cascade');
            $table->integer('numero_echeance');
            $table->date('date_prevu');
            $table->decimal('montant_prevu', 15, 2);
            $table->decimal('montant_capital', 15, 2);
            $table->decimal('montant_interet', 15, 2);
            $table->enum('statut', ['en_attente', 'paye', 'retarde'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('echeances');
    }
};