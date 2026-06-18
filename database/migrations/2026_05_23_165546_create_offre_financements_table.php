<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offre_financements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_bailleur')->constrained('bailleurs')->onDelete('cascade');
            $table->decimal('montant_propose', 15, 2);
            $table->decimal('taux_interet', 5, 2);
            $table->integer('duree_mois');
            $table->text('conditions')->nullable();
            $table->string('secteur_cible')->nullable();
            $table->enum('statut', ['en_attente', 'accepte', 'rejete'])->default('en_attente');
            $table->timestamp('date_accord')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offre_financements');
    }
};