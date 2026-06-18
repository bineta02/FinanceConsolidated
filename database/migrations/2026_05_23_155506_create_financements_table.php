<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_bailleur')->constrained('users')->onDelete('cascade');
            $table->decimal('montant_accorde', 15, 2);
            $table->integer('duree'); // en mois
            $table->decimal('taux_interet', 5, 2);
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'rembourse']);
            $table->timestamp('date_accorde')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financements');
    }
};