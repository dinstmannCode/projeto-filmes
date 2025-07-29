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
    public function index(TmdbService $tmdbService)
    {
        $favorites = $tmdbService->getFavoriteMoviesWithGenres();
        return response()->json($favorites);
    }


    public function store(Request $request, TmdbService $tmdbService)
    {
        $data = $request->validate([
            'tmdb_id' => 'required|unique:movie_favorites,tmdb_id',
            'title' => 'required|string',
            'poster_path' => 'nullable|string',
            'vote_average' => 'nullable|numeric',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'integer',
            'genres' => 'nullable',
        ]);

        if (isset($data['genres']) && is_string($data['genres'])) {
            $data['genres'] = array_map('trim', explode(',', $data['genres']));
        }


        if (!isset($data['genres']) && isset($data['genre_ids'])) {
            $genresMap = $tmdbService->getGenres();
            $data['genres'] = array_map(function ($id) use ($genresMap) {
                return $genresMap[$id] ?? '';
            }, $data['genre_ids']);
        }


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
        $favorite = MovieFavorite::where('tmdb_id', (string) $tmdb_id)->first();

        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Favorite deleted successfully'], 200);
    }
}
