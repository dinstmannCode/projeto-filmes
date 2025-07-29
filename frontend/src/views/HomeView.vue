<template>
  <Navbar v-model="searchQuery" />
  <div class="max-w-7xl mx-auto px-4 py-4 pt-28">

    <div v-if="!loading && filteredMovies.length === 0" class="text-center text-gray-400 mt-10">
      Nenhum filme encontrado! Que tal procurar outro título?
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-8">
      <MovieCard v-for="movie in filteredMovies" :key="movie.id" :movie="movie" :isFavorite="movie.is_favorite"
        @favorite="addToFavorites" />
    </div>

    <div v-if="loading" class="text-center text-purple-400 mt-6 animate-pulse">
      Carregando mais filmes...
    </div>
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue'
import MovieCard from '../components/MovieCard.vue'
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { fetchPopularMoviesWithFavoriteStatus, addFavoriteMovie } from '../services/api'

const searchQuery = ref('')
const movies = ref([])
const page = ref(1)
const loading = ref(false)

const filteredMovies = computed(() => {
  if (!searchQuery.value) return movies.value
  return movies.value.filter(movie =>
    movie.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const fetchMovies = async () => {
  if (loading.value) return
  loading.value = true
  const newMovies = await fetchPopularMoviesWithFavoriteStatus(page.value)
  movies.value.push(...newMovies)
  page.value++
  loading.value = false

  const uniqueMovies = new Map()

  movies.value = [...movies.value, ...newMovies].filter(movie => {
    if (uniqueMovies.has(movie.id)) return false
    uniqueMovies.set(movie.id, true)
    return true
  })
}

const addToFavorites = async (movie) => {
  console.log('Adicionando filme aos favoritos:', movie)
  try {
    const genreIds = Array.isArray(movie.genre_ids) ? movie.genre_ids : []
    const genresArray = Array.isArray(movie.genres)
      ? movie.genres
      : typeof movie.genres === 'string'
        ? movie.genres.split(',').map(s => s.trim())
        : []

    if (!genreIds.length && !genresArray.length) {
      console.warn(`Filme "${movie.title}" não possui gêneros válidos, ignorando...`)
      return
    }

    await addFavoriteMovie({
      tmdb_id: movie.id,
      title: movie.title,
      poster_path: movie.poster_path,
      vote_average: movie.vote_average,
      genre_ids: genreIds,
      genres: genresArray
    })

    const index = movies.value.findIndex(m => m.id === movie.id)
    if (index !== -1) {
      movies.value[index].is_favorite = true
    }
  } catch (error) {
    console.error('Erro ao adicionar favorito:', error)
  }
}


onMounted(async () => {
  await fetchMovies()
  window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})

const handleScroll = () => {
  const bottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 200
  if (bottom) {
    fetchMovies()
  }
}
</script>
