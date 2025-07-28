<?php

namespace App\Domains\Movies\Http\Controllers;

use App\Domains\Movies\Models\MovieFavorite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MovieFavoriteController extends Controller
{
    /**
     * Store a newly created movie favorite in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $favorites = MovieFavorite::all();
        return response()->json($favorites);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tmdb_id' => 'required|string|unique:movie_favorites,tmdb_id',
            'title' => 'required|string',
            'poster_path' => 'nullable|string',
            'vote_average' => 'nullable|numeric',
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
