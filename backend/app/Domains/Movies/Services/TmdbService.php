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
        $genres = $this->getGenres();

        $allMovies = [];

        for ($page = 1; $page <= $maxPages; $page++) {
            $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
                'api_key' => $this->apiKey,
                'language' => 'pt-BR',
                'page' => $page
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $allMovies = array_merge($allMovies, $this->mapMoviesWithGenres($data['results'], $genres));
            } else {
                break;
            }
        }

        foreach ($allMovies as &$movie) { $movie['genres'] = implode(', ', $movie['genres']);}

        // TODO: implementar propriedade favorite = boolean

        return $allMovies;
    }

    public function getGenres(): array
    {
        $response = Http::get('https://api.themoviedb.org/3/genre/movie/list', [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return array_column($data['genres'], 'name', 'id');
        }

        return [];
    }
    public function mapMoviesWithGenres(array $movies, array $genres): array
    {
        return array_map(function ($movie) use ($genres) {
            if (isset($movie['genre_ids'])) {
                $movie['genres'] = array_map(function ($genreId) use ($genres) {
                    return $genres[$genreId] ?? '';
                }, $movie['genre_ids']);
            } else {
                $movie['genres'] = [];
            }

            return $movie;
        }, $movies);
    }
}

