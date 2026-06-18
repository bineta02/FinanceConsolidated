<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garanties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_financement')->constrained('financements')->onDelete('cascade');
            $table->string('type_garantie');
            $table->decimal('valeur_estime', 15, 2);
            $table->string('document_url');
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garanties');
    }
};