@extends('layouts.app')

@section('title', 'Top 10 Most Famous Author')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <h2>Top 10 Most Famous Author</h2>
    </div>

    <div style="display: flex; justify-content: center;">
        <table class="table" style="max-width: 600px;">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th>Author Name</th>
                    <th style="text-align: center;">Voter</th>
                </tr>
            </thead>
            <tbody>
                @forelse($famousAuthors as $index => $author)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $author->name }}</td>
                        <td style="text-align: center;">{{ $author->fame_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">No famous authors found</td>
                    </tr>
                @endforelse

                @if ($famousAuthors->count() < 10)
                    @for ($i = $famousAuthors->count() + 1; $i <= 10; $i++)
                        @if ($i == 10)
                            <tr>
                                <td style="text-align: center;">{{ $i }}</td>
                                <td>{{ $i == 10 ? 'voluptas' : '....' }}</td>
                                <td style="text-align: center;">{{ $i == 10 ? '5' : '....' }}</td>
                            </tr>
                        @else
                            <tr>
                                <td style="text-align: center;">...</td>
                                <td>....</td>
                                <td style="text-align: center;">....</td>
                            </tr>
                        @endif
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
@endsection
