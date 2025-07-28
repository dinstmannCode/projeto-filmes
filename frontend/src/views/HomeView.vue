<template>
  <div>
    <SearchBar v-model="searchQuery" />

    <div v-if="filteredMovies.length === 0" class="text-center text-gray-500 mt-10">
      Filme não encontrado. =(
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mt-6">
      <MovieCard
        v-for="movie in filteredMovies"
        :key="movie.id"
        :movie="movie"
        @favorite="addToFavorites"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { fetchPopularMovies, addFavoriteMovie } from '../services/api';
import MovieCard from '../components/MovieCard.vue';
import SearchBar from '../components/SearchBar.vue';

const movies = ref([]);
const searchQuery = ref('');

const filteredMovies = computed(() => {
  if (!searchQuery.value) return movies.value;
  return movies.value.filter(movie =>
    movie.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const fetchMovies = async () => {
  movies.value = await fetchPopularMovies();
};

const addToFavorites = async (movie) => {
  try {
    await addFavoriteMovie(movie);
    alert('Eba! Filme adicionado aos favoritos!');
  } catch (err) {
    alert('Ixi, parece que esse filme já está nos favoritos.');
  }
};

onMounted(fetchMovies);
</script>
