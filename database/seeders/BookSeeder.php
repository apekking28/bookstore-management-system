<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 100,000 books...');

        // Get existing author and category IDs for performance
        $authorIds = Author::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        // Create books in chunks to avoid memory issues
        $chunkSize = 1000;
        $totalBooks = 100000;

        for ($i = 0; $i < $totalBooks / $chunkSize; $i++) {
            $books = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $books[] = [
                    'title' => fake()->sentence(rand(2, 6)),
                    'author_id' => fake()->randomElement($authorIds),
                    'category_id' => fake()->randomElement($categoryIds),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Book::insert($books);
            $this->command->info("Created " . (($i + 1) * $chunkSize) . " books");
        }

        $this->command->info('Books created successfully!');
    }
}
