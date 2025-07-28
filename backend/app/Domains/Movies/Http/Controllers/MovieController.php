<?php

namespace App\Domains\Movies\Http\Controllers;

use App\Domains\Movies\Services\TmdbService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * Get all movies data from TMDB service.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $movies = $this->tmdbService->getPopularMovies(1);

        if (empty($movies)) {
            return response()->json(['message' => 'No movies found'], 404);
        }
        
        return response()->json($movies);
    }
}