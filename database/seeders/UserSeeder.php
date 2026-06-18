<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'prenom' => 'Bineta',
                'nom' => 'Ndoye',
                'email' => 'bineta@gmail.com',
                'mot_de_passe' => Hash::make('bineta123'),
                'telephone' => '771234567',
                'role' => 'admin',
                'statut' => 'actif',
                'email_verified_at' => now(),
                'remember_token' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'default.png',
            ],

            [
                'prenom' => 'Sanou',
                'nom' => 'Ndoye',
                'email' => 'sanou@gmail.com',
                'mot_de_passe' => Hash::make('sanou123'),
                'telephone' => '771234567',
                'role' => 'bailleur',
                'statut' => 'actif',
                'email_verified_at' => now(),
                'remember_token' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'default.png',
            ],

            [
                'prenom' => 'Ndeye',
                'nom' => 'Ndiaye',
                'email' => 'ndeye@gmail.com',
                'mot_de_passe' => Hash::make('ndeye123'),
                'telephone' => '771234567',
                'role' => 'entrepreneur',
                'statut' => 'actif',
                'email_verified_at' => now(),
                'remember_token' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'avatar' => 'default.png',
            ],
        ]);
    }
}