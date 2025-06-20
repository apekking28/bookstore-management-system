@extends('layouts.app')

@section('title', 'List of Books')

@section('content')
    <form method="GET" action="{{ route('books.index') }}">
        <div class="form-group">
            <label for="list_shown">List shown :</label>
            <select name="list_shown" id="list_shown" onchange="this.form.submit()">
                @foreach ([10, 20, 30, 40, 50, 60, 70, 80, 90, 100] as $option)
                    <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="search">Search :</label>
            <input type="text" name="search" id="search" value="{{ $search }}"
                placeholder="Search by book name or author name">
            <button type="submit" class="btn">SUBMIT</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Book Name</th>
                <th>Category Name</th>
                <th>Author Name</th>
                <th>Average Rating</th>
                <th>Voter</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $index => $book)
                <tr>
                    <td>{{ $books->firstItem() + $index }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->ratings_avg_rating ? number_format($book->ratings_avg_rating, 2) : '0.00' }}</td>
                    <td>{{ $book->ratings_count ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No books found</td>
                </tr>
            @endforelse

            @if ($books->hasPages())
                <tr>
                    <td colspan="6">
                        <div style="text-align: center;">
                            ...
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($books->hasPages())
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($books->onFirstPage())
                <span style="padding: 8px 12px; color: #ccc; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">«
                    Previous</span>
            @else
                <a href="{{ $books->previousPageUrl() }}"
                    style="padding: 8px 12px; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">«
                    Previous</a>
            @endif

            {{-- Smart Pagination Logic --}}
            @php
                $current = $books->currentPage();
                $last = $books->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            {{-- First Page --}}
            @if ($start > 1)
                <a href="{{ $books->url(1) }}"
                    style="padding: 8px 12px; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">1</a>
                @if ($start > 2)
                    <span style="padding: 8px 12px; color: #ccc;">...</span>
                @endif
            @endif

            {{-- Page Range --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <span
                        style="background: #007bff; color: white; padding: 8px 12px; border-radius: 4px; margin: 0 2px; border: 1px solid #007bff;">{{ $i }}</span>
                @else
                    <a href="{{ $books->url($i) }}"
                        style="padding: 8px 12px; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">{{ $i }}</a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span style="padding: 8px 12px; color: #ccc;">...</span>
                @endif
                <a href="{{ $books->url($last) }}"
                    style="padding: 8px 12px; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">{{ $last }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}"
                    style="padding: 8px 12px; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">Next
                    »</a>
            @else
                <span
                    style="padding: 8px 12px; color: #ccc; border: 1px solid #ddd; border-radius: 4px; margin: 0 2px;">Next
                    »</span>
            @endif
        </div>
    @endif

    <div style="margin-top: 20px; color: #666;">
        Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }}
        of {{ $books->total() }} results
    </div>
@endsection
