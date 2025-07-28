<script setup>
const props = defineProps({
  movie: Object,
  isFavorite: Boolean
})

const emit = defineEmits(['favorite', 'unfavorite'])

const handleFavorite = () => {
  if (props.isFavorite) {
    emit('unfavorite', props.movie)
  } else {
    emit('favorite', props.movie)
  }
}
</script>

<template>
  <div>
    <div
      class="group relative bg-[#1a1a1a] rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-purple-800 hover:scale-105"
    >
      <img
        :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
        :alt="movie.title"
        class="w-full h-[360px] object-cover"
      />

      <div
        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent text-white flex flex-col justify-end p-4 transition-transform duration-300 translate-y-full group-hover:translate-y-0"
      >
        <p class="text-sm mb-2 line-clamp-4 text-purple-200">
          {{ movie.overview || 'No description available.' }}
        </p>
      </div>

      <div class="p-4 z-10">
        <h3 class="text-md font-semibold text-white mb-1 line-clamp-2">
          {{ movie.title }}
        </h3>
        <p class="text-sm text-purple-300">⭐ {{ movie.vote_average ?? 'N/A' }}</p>
      </div>
    </div>

    <div class="p-4 pt-0 z-10">
      <button
        @click="handleFavorite"
        :class="[
          'px-4 py-2 rounded-lg font-medium text-white transition-colors duration-300',
          isFavorite ? 'bg-pink-600 hover:bg-pink-700' : 'bg-violet-600 hover:bg-violet-700'
        ]"
      >
        {{ isFavorite ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}
      </button>
    </div>
  </div>
</template>
