import axios from 'axios';

// Endpoint base da API do TMDB
const TMDB_BASE_URL = 'https://api.themoviedb.org/3';
const TMDB_API_KEY = import.meta.env.VITE_TMDB_API_KEY;

// Endpoint do backend Laravel (ajuste se necessário)
const BACKEND_BASE_URL = 'http://localhost:8000/api';

/**
 * Busca todos os filmes
 */
export async function fetchPopularMoviesWithFavoriteStatus(page = 1) {
  const response = await axios.get(`${BACKEND_BASE_URL}/movies/popular-with-favorites`, {
    params: { page }
  })
  return response.data
}
/**
 * Envia favorito pro backend
 */
export async function addFavoriteMovie(movie) {
  return axios.post(`${BACKEND_BASE_URL}/movies/add-favorites`, {
    tmdb_id: movie.tmdb_id,
    title: movie.title,
    poster_path: movie.poster_path,
    vote_average: movie.vote_average,
    genres: movie.genres,
    genre_ids: movie.genre_ids
  });
}

/**
 * Busca favoritos do backend para favoritos
 */
export async function getFavoriteMovies() {
  const response = await axios.get(`${BACKEND_BASE_URL}/movies/add-favorites`);
  
  return response.data;
}

/**
 *  Deleta favorito do backend
 */
export async function deleteFavoriteMovie(tmdb_id) {
  return axios.delete(`${BACKEND_BASE_URL}/movies/favorites/${tmdb_id}`);
}
