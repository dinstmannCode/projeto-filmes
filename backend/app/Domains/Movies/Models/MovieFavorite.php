<?php

namespace App\Domains\Movies\Models;

use Illuminate\Database\Eloquent\Model;

// new MovieFavorite
class MovieFavorite extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'poster_path',
        'vote_average',
        'genre_ids',
        'genres',
    ];

    protected $casts = [
        'genre_ids' => 'array',
        'genres' => 'array',
    ];
}
