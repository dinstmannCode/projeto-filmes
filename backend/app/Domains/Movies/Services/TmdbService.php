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

    public function getPopularMovies(int $maxPages = 5): array
    {

        $allMovies = [];

        for ($page = 1; $page <= $maxPages; $page++) {
            $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
                'api_key' => $this->apiKey,
                'language' => 'pt-BR',
                'page' => $page
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $allMovies = array_merge($allMovies, $data['results']);
            } else {
                break; 
            }
        }        

        return $allMovies;
    }
}
