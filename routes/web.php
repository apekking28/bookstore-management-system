<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books', [BookController::class, 'index'])->name('books.list');

Route::get('/authors/famous', [AuthorController::class, 'famousAuthors'])->name('authors.famous');

Route::get('/ratings/create', [RatingController::class, 'create'])->name('ratings.create');
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

// AJAX route untuk dependent dropdown
Route::get('/api/books-by-author/{author}', [RatingController::class, 'getBooksByAuthor'])->name('api.books.by.author');