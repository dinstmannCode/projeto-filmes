<template>
  <Navbar v-model="searchQuery" :showSearch="false" />
  <div class="max-w-7xl mx-auto px-4 py-4 pt-28">
    <h1 class="flex mx-auto text-3xl font-bold mt-8 mb-8 text-king-purple uppercase">Meus filmes favoritos</h1>

    <div v-if="genreList.length" class="flex text-gray-500 mb-4">
      <ul class="flex justify-center mx-auto flex-wrap mb-6 gap-2">
        <li @click="selectedGenre = null"
            class="mr-2 mb-2 px-2 py-1 rounded-md text-sm cursor-pointer transition-colors duration-300"
            :class="!selectedGenre
              ? 'bg-king-purple text-white'
              : 'bg-gray-200 text-gray-700 hover:bg-gray-500 hover:text-white'">
          Todos os gêneros
        </li>
        <li v-for="genre in genreList" :key="genre"
            @click="selectedGenre = genre === selectedGenre ? null : genre"
            class="mr-2 mb-2 px-2 py-1 rounded-md text-sm cursor-pointer transition-colors duration-300"
            :class="genre === selectedGenre
              ? 'bg-king-purple text-white'
              : 'bg-gray-200 text-gray-700 hover:bg-gray-500 hover:text-white'">
          {{ genre }}
        </li>
      </ul>
    </div>

    <div v-if="filteredFavorites.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <MovieCard
        v-for="movie in filteredFavorites"
        :key="movie.tmdb_id"
        :movie="movie"
        :isFavorite="true"
        @unfavorite="openModal(movie)"
        :showOverview="false"
      />
    </div>

    <p v-else class="text-gray-500 text-center mt-10">
      Ops! Nenhum filme favorito encontrado {{ selectedGenre ? `para o gênero '${selectedGenre}'` : '' }}.
    </p>

    <ConfirmModal
      v-if="selectedMovie"
      :title="`Remover '${selectedMovie.title}' dos favoritos?`"
      @confirm="removeFavorite"
      @cancel="selectedMovie = null"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import MovieCard from '../components/MovieCard.vue'
import ConfirmModal from '../components/ConfirmModal.vue'
import Navbar from '../components/Navbar.vue'
import { getFavoriteMovies, deleteFavoriteMovie } from '../services/api'

const searchQuery = ref('')
const selectedGenre = ref(null)
const favorites = ref([])
const selectedMovie = ref(null)

const fetchFavorites = async () => {
  try {
    favorites.value = await getFavoriteMovies()
  } catch (error) {
    console.error('Erro ao carregar favoritos:', error)
  }
}

const genreList = computed(() => {
  const genres = new Set()
  favorites.value.forEach(movie => {
    if (movie.genres && typeof movie.genres === 'string') {
      movie.genres.split(',').forEach(g => {
        const clean = g.trim()
        if (clean) genres.add(clean)
      })
    }
  })
  return Array.from(genres).sort()
})

const filteredFavorites = computed(() => {
  if (!selectedGenre.value) return favorites.value

  return favorites.value.filter(movie =>
    movie.genres
      ?.split(',')
      .map(g => g.trim())
      .includes(selectedGenre.value)
  )
})

const openModal = (movie) => {
  selectedMovie.value = movie
}

const removeFavorite = async () => {
  if (!selectedMovie.value?.tmdb_id && !selectedMovie.value?.id) {
    return
  }

  const id = selectedMovie.value.tmdb_id?.toString() || selectedMovie.value.id?.toString()

  try {
    await deleteFavoriteMovie(id)
    favorites.value = favorites.value.filter(fav =>
      fav.tmdb_id !== id && fav.id !== id
    )
  } catch (error) {
    console.error('Erro ao remover favorito:', error)
  } finally {
    selectedMovie.value = null
  }
}

onMounted(fetchFavorites)
</script>

<style scoped>
h1 {
  justify-content: center;
  margin-bottom: 2rem;
}
.bg-king-purple {
  background-color: #782dc8;
}
</style>
