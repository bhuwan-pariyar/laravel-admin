<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Lara Wire',
            'username' => 'larawire',
            'email' => 'larawire@dev.com',
            'password' => bcrypt('larawire@123'),
        ]);
    }
}
