<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'category_id',
    ];

    /**
     * Get the author of the book
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the category of the book
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all ratings for this book
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Scope for books with average rating and vote count
     */
    public function scopeWithRatingStats($query)
    {
        return $query->withAvg('ratings', 'rating')
            ->withCount('ratings');
    }

    /**
     * Scope for search by title or author name
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($query) use ($term) {
            $query->where('title', 'LIKE', "%{$term}%")
                ->orWhereHas('author', function ($query) use ($term) {
                    $query->where('name', 'LIKE', "%{$term}%");
                });
        });
    }
}
