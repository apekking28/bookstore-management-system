<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'rating' => $this->faker->numberBetween(1, 10),
        ];
    }
}