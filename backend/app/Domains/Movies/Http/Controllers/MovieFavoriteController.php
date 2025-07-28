<?php

namespace App\Domains\Movies\Http\Controllers;

use App\Domains\Movies\Models\MovieFavorite;
use App\Domains\Movies\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MovieFavoriteController extends Controller
{
    /**
     * Store a newly created movie favorite in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function index()
    {
        $favoritesWithGenres = $this->tmdbService->getPopularMovies(1); // Fetching genres for favorites);
        
        return response()->json($favoritesWithGenres);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tmdb_id' => 'required|string|unique:movie_favorites,tmdb_id',
            'title' => 'required|string',
            'poster_path' => 'nullable|string',
            'vote_average' => 'nullable|numeric',
            'genres' => 'nullable|array',
        ]);

        $favorite = MovieFavorite::create($data);

        return response()->json($favorite, 201);
    }

    /**
     * Remove the specified movie favorite from storage.
     *
     * @param  int  $tmdb_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($tmdb_id)
    {
        $favorite = MovieFavorite::where('tmdb_id', $tmdb_id)->first();
        
        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Favorite deleted successfully'], 200);

    }
}
