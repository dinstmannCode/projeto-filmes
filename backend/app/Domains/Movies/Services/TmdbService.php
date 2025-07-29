<?php

namespace App\Domains\Movies\Services;

use App\Domains\Movies\Models\MovieFavorite;
use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key');
    }

    public function getPopularMovies(int $maxPages = 1): array
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

        foreach ($allMovies as &$movie) {
            $movie['genres'] = implode(', ', $movie['genres']);
        }

        return $allMovies;
    }

    public function getPopularMoviesWithFavorites(int $maxPages = 5): array
    {
        $popularMovies = $this->getPopularMovies($maxPages);
        $favoriteIds = MovieFavorite::pluck('tmdb_id')->toArray();

        foreach ($popularMovies as &$movie) {
            $movie['is_favorite'] = in_array($movie['id'], $favoriteIds);
        }

        return $popularMovies;
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

    public function getFavoriteMoviesWithGenres(): array
    {
        $favorites = MovieFavorite::all();
        $genres = $this->getGenres();

        $favoriteMovies = [];

        foreach ($favorites as $fav) {
            $movie = $fav->toArray();

            if (!empty($movie['genre_ids'])) {
                $movie['genres'] = array_map(function ($id) use ($genres) {
                    return $genres[$id] ?? '';
                }, $movie['genre_ids']);
            }

            $movie['genres'] = implode(', ', $movie['genres'] ?? []);

            $movie['is_favorite'] = true;

            $favoriteMovies[] = $movie;
        }

        return $favoriteMovies;
    }
}
