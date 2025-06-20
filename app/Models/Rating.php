<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the book that was rated
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Validation rules
     */
    public static function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:10',
        ];
    }
}
