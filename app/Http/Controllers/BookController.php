<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Default parameters
        $perPage = $request->get('list_shown', 10);
        $search = $request->get('search', '');

        // Validate per page
        $allowedPerPage = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // Build query
        $query = Book::with(['author', 'category'])
            ->withRatingStats(); // This includes withAvg and withCount for ratings

        // Apply search filter
        if (!empty($search)) {
            $query->search($search);
        }

        // Order by average rating descending (highest first)
        $books = $query->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count') // Secondary sort by vote count
            ->paginate($perPage)
            ->withQueryString(); // Preserve query parameters in pagination

        return view('books.index', compact('books', 'perPage', 'search'));
    }
}
