import axios from 'axios';

// Endpoint base da API do TMDB
const TMDB_BASE_URL = 'https://api.themoviedb.org/3';
const TMDB_API_KEY = import.meta.env.VITE_TMDB_API_KEY;

// Endpoint do backend Laravel (ajuste se necessário)
const BACKEND_BASE_URL = 'http://localhost:8000/api';

/**
 * Busca filmes populares da TMDB (paginação limitada)
 */
export async function fetchPopularMovies(pages = 1) {
  const allMovies = [];

  for (let page = 1; page <= pages; page++) {
    const response = await axios.get(`${TMDB_BASE_URL}/movie/popular`, {
      params: {
        api_key: TMDB_API_KEY,
        language: 'pt-BR',
        page,
      },
    });

    allMovies.push(...response.data.results);
  }

  return allMovies;
}

/**
 * Envia favorito pro backend
 */
export async function addFavoriteMovie(movie) {
  return axios.post(`${BACKEND_BASE_URL}/movies/favorites`, {
    tmdb_id: movie.tmdb_id,
    title: movie.title,
    poster_path: movie.poster_path,
    vote_average: movie.vote_average,
  });
}

/**
 * Busca favoritos do backend
 */
export async function getFavoriteMovies() {
  const response = await axios.get(`${BACKEND_BASE_URL}/movies/favorites`);
  return response.data;
}

export async function deleteFavoriteMovie(tmdb_id) {
  return axios.delete(`${BACKEND_BASE_URL}/movies/favorites/${tmdb_id}`);
}
