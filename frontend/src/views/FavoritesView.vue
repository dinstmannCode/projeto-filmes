<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-king-purple">Your Favorite Movies</h1>

    <div v-if="favorites.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <MovieCard
        v-for="movie in favorites"
        :key="movie.tmdb_id"
        :movie="movie"
        :isFavorite="true"
        @unfavorite="openModal(movie)"
      />
    </div>

    <p v-else class="text-gray-500">You haven’t added any favorites yet.</p>

    <ConfirmModal
      v-if="selectedMovie"
      :title="`Remove '${selectedMovie.title}' from favorites?`"
      @confirm="removeFavorite"
      @cancel="selectedMovie = null"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import MovieCard from '../components/MovieCard.vue'
import ConfirmModal from '../components/ConfirmModal.vue'
import { getFavoriteMovies, deleteFavoriteMovie } from '../services/api' // ✅ importante

const favorites = ref([])
const selectedMovie = ref(null)

const fetchFavorites = async () => {
  try {
    favorites.value = await getFavoriteMovies()
  } catch (error) {
    console.error('Error loading favorites:', error)
  }
}

const openModal = (movie) => {
  selectedMovie.value = movie
}

const removeFavorite = async () => {
  try {
    await deleteFavoriteMovie(selectedMovie.value.tmdb_id)
    favorites.value = favorites.value.filter(fav => fav.tmdb_id !== selectedMovie.value.tmdb_id)
  } catch (error) {
    console.error('Error deleting movie:', error)
  } finally {
    selectedMovie.value = null
  }
}

onMounted(fetchFavorites)
</script>
