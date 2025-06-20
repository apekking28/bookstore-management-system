@extends('layouts.app')

@section('title', 'Insert Rating')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <h2>Insert Rating</h2>
    </div>

    <div style="display: flex; justify-content: center;">
        <form method="POST" action="{{ route('ratings.store') }}" style="max-width: 500px; width: 100%;">
            @csrf

            <div class="form-group">
                <label for="book_author">Book Author :</label>
                <select name="book_author" id="book_author" style="width: 300px;" required>
                    <option value="">Select Author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ old('book_author') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="book_name">Book Name :</label>
                <select name="book_name" id="book_name" style="width: 300px;" required disabled>
                    <option value="">Select Book</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rating">Rating :</label>
                <select name="rating" id="rating" style="width: 300px;" required>
                    <option value="">Select Rating</option>
                    @foreach ($ratings as $rate)
                        <option value="{{ $rate }}" {{ old('rating') == $rate ? 'selected' : '' }}>
                            {{ $rate }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="btn">SUBMIT</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const authorSelect = document.getElementById('book_author');
            const bookSelect = document.getElementById('book_name');

            authorSelect.addEventListener('change', function() {
                const authorId = this.value;

                // Reset book dropdown
                bookSelect.innerHTML = '<option value="">Loading...</option>';
                bookSelect.disabled = true;

                if (authorId) {
                    // Fetch books by author
                    fetch(`/api/books-by-author/${authorId}`)
                        .then(response => response.json())
                        .then(books => {
                            bookSelect.innerHTML = '<option value="">Select Book</option>';

                            books.forEach(book => {
                                const option = document.createElement('option');
                                option.value = book.id;
                                option.textContent = book.title;

                                // Keep selected value if exists (for validation errors)
                                if ('{{ old('book_name') }}' == book.id) {
                                    option.selected = true;
                                }

                                bookSelect.appendChild(option);
                            });

                            bookSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error fetching books:', error);
                            bookSelect.innerHTML = '<option value="">Error loading books</option>';
                        });
                } else {
                    bookSelect.innerHTML = '<option value="">Select Book</option>';
                    bookSelect.disabled = true;
                }
            });

            // Trigger change event if author is already selected (for validation errors)
            if (authorSelect.value) {
                authorSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
