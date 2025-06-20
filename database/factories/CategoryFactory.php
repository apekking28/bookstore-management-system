<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $baseCategories = [
            'Fiction',
            'Non-Fiction',
            'Science Fiction',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Romance',
            'Horror',
            'Biography',
            'History',
            'Science',
            'Technology',
            'Business',
            'Self-Help',
            'Health',
            'Travel',
            'Cooking',
            'Art',
            'Music',
            'Sports',
            'Religion',
            'Philosophy',
            'Psychology',
            'Education',
            'Children',
            'Young Adult',
            'Poetry',
            'Drama',
            'Adventure',
            'Crime'
        ];

        $subcategories = [
            'Modern',
            'Classic',
            'Contemporary',
            'Advanced',
            'Beginner',
            'Professional',
            'Academic',
            'Popular',
            'International',
            'Local',
            'Digital',
            'Traditional',
            'Experimental',
            'Practical',
            'Theoretical'
        ];

        // Create unique combinations
        $baseCategory = $this->faker->randomElement($baseCategories);
        $subCategory = $this->faker->randomElement($subcategories);
        $suffix = $this->faker->optional(0.7)->word(); // 70% chance to add extra word

        $name = $baseCategory . ' ' . $subCategory;
        if ($suffix) {
            $name .= ' ' . ucfirst($suffix);
        }

        return [
            'name' => $name,
        ];
    }
}
