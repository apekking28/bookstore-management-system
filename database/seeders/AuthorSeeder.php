<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 1,000 authors...');
        
        Author::factory(1000)->create();
        
        $this->command->info('Authors created successfully!');
    }
}