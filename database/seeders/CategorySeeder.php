<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 3,000 categories...');
        
        // Use chunk to avoid memory issues and ensure unique names
        $chunkSize = 100;
        $totalCategories = 3000;
        
        for ($i = 0; $i < $totalCategories / $chunkSize; $i++) {
            $categories = [];
            
            for ($j = 0; $j < $chunkSize; $j++) {
                $categories[] = [
                    'name' => $this->generateUniqueCategoryName(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            Category::insert($categories);
            $this->command->info("Created " . (($i + 1) * $chunkSize) . " categories");
        }
        
        $this->command->info('Categories created successfully!');
    }

    private function generateUniqueCategoryName(): string
    {
        $baseCategories = [
            'Fiction', 'Non-Fiction', 'Science Fiction', 'Fantasy', 'Mystery', 
            'Thriller', 'Romance', 'Horror', 'Biography', 'History',
            'Science', 'Technology', 'Business', 'Self-Help', 'Health',
            'Travel', 'Cooking', 'Art', 'Music', 'Sports',
            'Religion', 'Philosophy', 'Psychology', 'Education', 'Children',
            'Young Adult', 'Poetry', 'Drama', 'Adventure', 'Crime'
        ];

        $modifiers = [
            'Modern', 'Classic', 'Contemporary', 'Advanced', 'Beginner',
            'Professional', 'Academic', 'Popular', 'International', 'Local',
            'Digital', 'Traditional', 'Experimental', 'Practical', 'Theoretical',
            'Essential', 'Complete', 'Ultimate', 'Quick', 'Comprehensive'
        ];

        $extras = [
            'Guide', 'Manual', 'Handbook', 'Collection', 'Series',
            'Archive', 'Library', 'Anthology', 'Compendium', 'Reference'
        ];

        $base = fake()->randomElement($baseCategories);
        $modifier = fake()->randomElement($modifiers);
        $extra = fake()->optional(0.6)->randomElement($extras);
        
        $name = $modifier . ' ' . $base;
        if ($extra) {
            $name .= ' ' . $extra;
        }
        
        // Add random suffix for more uniqueness
        $name .= ' ' . fake()->numberBetween(1, 9999);
        
        return $name;
    }
}