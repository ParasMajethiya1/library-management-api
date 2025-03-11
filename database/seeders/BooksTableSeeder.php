<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Faker\Factory as Faker;
use Illuminate\Support\Str; // Import the Str class for UUID

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $title = $faker->sentence(3) . ' ' . Str::uuid(); // Always append UUID

            Book::create([
                'title' => $title,
                'author' => $faker->name,
                'description' => $faker->paragraph,
            ]);
        }
    }
}