<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        UserSeeder::class,          // 1. Crée d'abord Bineta, Sanou et Ndeye
        EntrepreneurSeeder::class,  // 2. Lie ensuite les détails d'entrepreneur à Ndeye
        BailleurSeeder::class,      // 3. Lie enfin les détails de investisseur à Sanou
    ]);
}
}
