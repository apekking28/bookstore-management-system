<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get all books for this author
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get all ratings through books (for fame calculation)
     */
    public function ratingsThoughBooks()
    {
        return $this->hasManyThrough(Rating::class, Book::class);
    }

    /**
     * Scope for famous authors (only ratings > 5)
     */
    public function scopeWithFameCount($query)
    {
        return $query->withCount(['ratingsThoughBooks as fame_count' => function ($query) {
            $query->where('rating', '>', 5);
        }]);
    }
}