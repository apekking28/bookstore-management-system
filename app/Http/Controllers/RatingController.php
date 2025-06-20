<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    public function create()
    {
        // Get all authors for dropdown
        $authors = Author::orderBy('name')->get();

        // Ratings scale 1-10
        $ratings = range(1, 10);

        return view('ratings.create', compact('authors', 'ratings'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'book_author' => 'required|exists:authors,id',
            'book_name' => [
                'required',
                'exists:books,id',
                // Ensure book belongs to selected author
                Rule::exists('books', 'id')->where(function ($query) use ($request) {
                    return $query->where('author_id', $request->book_author);
                })
            ],
            'rating' => 'required|integer|min:1|max:10',
        ], [
            'book_name.exists' => 'Selected book does not belong to the selected author.',
        ]);

        // Create rating
        Rating::create([
            'book_id' => $validated['book_name'],
            'rating' => $validated['rating'],
        ]);

        // Redirect to books list with success message
        return redirect()->route('books.index')->with('success', 'Rating submitted successfully!');
    }

    public function getBooksByAuthor($authorId)
    {
        // AJAX endpoint for dependent dropdown
        $books = Book::where('author_id', $authorId)
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($books);
    }
}
