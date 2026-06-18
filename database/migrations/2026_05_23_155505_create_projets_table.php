<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_entrepreneur')->constrained('entrepreneurs')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->decimal('montant_demande', 15, 2);
            $table->decimal('montant_collecte', 15, 2)->default(0);
            $table->string('categorie');
            $table->string('localisation');
            $table->timestamp('date_limite');
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'finance', 'termine'])->default('en_attente');
            $table->string('document_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};