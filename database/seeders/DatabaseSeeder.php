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
        // Create exactly 4 categories first
        $categories = \App\Models\Category::factory(3)->create();


        // Create a specific test user with 5 products
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->each(function ($user) {
            \App\Models\Product::factory(5)->create([
                'user_id' => $user->id,
                'category_id' => \App\Models\Category::inRandomOrder()->first()->id
            ]);
        });
    }
}
