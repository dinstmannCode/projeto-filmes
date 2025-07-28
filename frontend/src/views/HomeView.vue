<script setup>
import Navbar from '../components/Navbar.vue'
import MovieCard from '../components/MovieCard.vue'
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { fetchPopularMovies, addFavoriteMovie, getFavoriteMovies } from '../services/api'

const searchQuery = ref('')
const movies = ref([])
const page = ref(1)
const loading = ref(false)
const favorites = ref([]) // ✅ declarando os favoritos

const filteredMovies = computed(() => {
  if (!searchQuery.value) return movies.value
  return movies.value.filter(movie =>
    movie.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const fetchMovies = async () => {
  if (loading.value) return
  loading.value = true
  const newMovies = await fetchPopularMovies(page.value)
  movies.value.push(...newMovies)
  page.value++
  loading.value = false
}

const fetchFavorites = async () => {
  try {
    favorites.value = await getFavoriteMovies()
  } catch (error) {
    console.error('Erro ao carregar favoritos:', error)
  }
}

const addToFavorites = async (movie) => {
  try {
    await addFavoriteMovie({
      tmdb_id: movie.id.toString(),
      title: movie.title,
      poster_path: movie.poster_path,
      vote_average: movie.vote_average,
    })
    await fetchFavorites() // ✅ atualiza a lista local após adicionar
    console.log('Favorito adicionado com sucesso')
  } catch (error) {
    console.error('Erro ao adicionar favorito:', error)
  }
}

const isInFavorites = (id) => {
  return favorites.value.some(fav => fav.tmdb_id === id.toString())
}

onMounted(async () => {
  favorites.value = await getFavoriteMovies();
  await fetchMovies();
  window.addEventListener('scroll', handleScroll);
});


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

<template>
  <Navbar v-model="searchQuery" />
  <div class="max-w-7xl mx-auto px-4 py-4 pt-28">
    <div v-if="filteredMovies.length === 0" class="text-center text-gray-400 mt-10">
      Nenhum filme encontrado! Que tal procurar outro título?
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-8">
      <MovieCard
        v-for="movie in filteredMovies"
        :key="movie.id"
        :movie="movie"
        :isFavorite="isInFavorites(movie.id)"
        @favorite="addToFavorites"
      />
    </div>

    <div v-if="loading" class="text-center text-purple-400 mt-6 animate-pulse">
      Carregando mais filmes...
    </div>
  </div>
</template>
