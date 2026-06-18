<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrepreneurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->string('secteur_dactivite');
            $table->text('description_profil');
            $table->integer('annees_experiences');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrepreneurs');
    }
};