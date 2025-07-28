<?php

namespace App\Domains\Movies\Models;

use Illuminate\Database\Eloquent\Model;

class MovieFavorite extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'poster_path',
        'vote_average',
        'genres',
    ];
}
