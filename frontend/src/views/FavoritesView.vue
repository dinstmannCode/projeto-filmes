<template>
  <div>
    <h2 class="text-xl font-semibold mb-4">Meus Favoritos</h2>

    <div v-if="favorites.length === 0" class="text-center text-gray-500 mt-10">
      Ué, você ainda não tem filmes favoritos. Que tal adicionar alguns?
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
      <MovieCard
        v-for="movie in favorites"
        :key="movie.id"
        :movie="movie"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getFavoriteMovies } from '../services/api';
import MovieCard from '../components/MovieCard.vue';

const favorites = ref([]);

const fetchFavorites = async () => {
  favorites.value = await getFavoriteMovies();
};

onMounted(fetchFavorites);
</script>
