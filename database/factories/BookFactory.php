<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(rand(2, 6)),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
        ];
    }
}