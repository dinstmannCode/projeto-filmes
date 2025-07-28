<template>
  <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
    <img
      :src="posterUrl"
      :alt="movie.title"
      class="w-full h-72 object-cover"
    />
    <div class="p-3 flex flex-col justify-between h-[120px]">
      <h2 class="text-sm font-semibold mb-2 truncate" :title="movie.title">
        {{ movie.title }}
      </h2>
      <div class="flex justify-between items-center">
        <span class="text-xs text-gray-500">⭐ {{ movie.vote_average ?? 'N/A' }}</span>
        <button
          @click="handleFavorite"
          class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
        >
          Favoritar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  movie: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['favorite']);

const handleFavorite = () => {
  emit('favorite', {
    tmdb_id: props.movie.id,
    title: props.movie.title,
    poster_path: props.movie.poster_path,
    vote_average: props.movie.vote_average,
  });
};

const posterUrl = computed(() => {
  return props.movie.poster_path
    ? `https://image.tmdb.org/t/p/w500${props.movie.poster_path}`
    : 'https://via.placeholder.com/500x750?text=No+Image';
});
</script>
