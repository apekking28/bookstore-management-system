<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function famousAuthors()
    {
        // Get top 10 famous authors based on voter count (only ratings > 5)
        $famousAuthors = Author::withFameCount()
            ->orderByDesc('fame_count')
            ->take(10)
            ->get();

        return view('authors.famous', compact('famousAuthors'));
    }
}
