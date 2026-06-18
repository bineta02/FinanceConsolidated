<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntrepreneurSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère l'utilisateur Ndeye
        $ndeye = DB::table('users')->where('email', 'ndeye@gmail.com')->first();

        if ($ndeye) {
            DB::table('entrepreneurs')->insert([
                [
                    'id_utilisateur'     => $ndeye->id, // La clé étrangère
                    'secteur_dactivite'  => 'Agriculture numérique',
                    'description_profil' => 'Développement de solutions connectées pour la gestion des parcelles.',
                    'annees_experiences' => '2ans',
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]
            ]);
        }
    }
}