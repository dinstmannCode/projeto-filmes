<?php

namespace App\Domains\Movies\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key');
    }

    public function getPopularMovies(): array
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR',
            'page' => 1,
        ]);

        if ($response->successful()) {
            return $response->json()['results'] ?? [];
        }
        // Handle the case where the request fails
        if ($response->failed()) {
            throw new \Exception('Failed to fetch popular movies from TMDB');
        }

        return [];
    }
}
