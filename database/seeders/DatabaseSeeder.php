<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use KodePandai\Indonesia\IndonesiaDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(IndonesiaDatabaseSeeder::class);
        if (User::first() == null) {
            User::factory()->create([
                'name' => 'Richie Zakaria',
                'email' => 'admin@admin.com',
            ]);
        }
    }
}
