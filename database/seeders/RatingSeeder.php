<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 500,000 ratings...');

        // Get existing book IDs for performance
        $bookIds = Book::pluck('id')->toArray();

        // Create ratings in chunks to avoid memory issues
        $chunkSize = 2000;
        $totalRatings = 500000;

        for ($i = 0; $i < $totalRatings / $chunkSize; $i++) {
            $ratings = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $ratings[] = [
                    'book_id' => fake()->randomElement($bookIds),
                    'rating' => fake()->numberBetween(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Rating::insert($ratings);
            $this->command->info("Created " . (($i + 1) * $chunkSize) . " ratings");
        }

        $this->command->info('Ratings created successfully!');
    }
}
