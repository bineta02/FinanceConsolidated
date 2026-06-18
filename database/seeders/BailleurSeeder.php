<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BailleurSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère l'utilisateur Sanou
        $sanou = DB::table('users')->where('email', 'sanou@gmail.com')->first();

        if ($sanou) {
            DB::table('bailleurs')->insert([
                [
                    'id_utilisateur'   => $sanou->id, // La clé étrangère
                    'capital'          => '5000000',
                    'montant_max_projet'=> '1500000',
                    'secteurs_preferes'=> 'AgriTech, Fintech',
                    'types_bailleurs'  => 'Business Angel',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            ]);
        }
    }
}