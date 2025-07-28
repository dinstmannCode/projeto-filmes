<template>
  <div>
    <div
      class="group relative bg-[#1a1a1a] rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-purple-800 hover:scale-105">
      <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" :alt="movie.title"
        class="w-full h-[360px] object-cover" />

      <div v-if="showOverview"
        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent text-white flex flex-col justify-end p-4 transition-transform duration-300 translate-y-full group-hover:translate-y-0">
        <p class="text-sm mb-2 line-clamp-4 text-purple-200">
          {{ movie.overview || 'Sem sinopse disponível' }}
        </p>
      </div>

      <div class="p-4 z-10">
        <h3 class="text-md font-semibold text-white mb-1 line-clamp-2">
          {{ movie.title }}
        </h3>
        <p class="text-sm text-purple-300">⭐ {{ movie.vote_average ?? 'N/A' }}</p>
      </div>

      <div class="p-4 pt-0 z-10">
        <!-- Botão de favorito -->
        <button @click="handleFavorite" :class="[
          'absolute top-4 right-4 z-10 px-3 py-1 rounded-full text-md font-semibold shadow-md transition-all duration-300 cursor-pointer',
          isFavorite
            ? 'bg-pink-600 text-white hover:bg-pink-700'
            : 'bg-violet-600 text-white hover:bg-violet-700',
          animating ? 'scale-110' : 'scale-100'
        ]">
          {{ isFavorite ? '♥' : '♡' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  movie: Object,
  isFavorite: Boolean,
  showOverview: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['favorite', 'unfavorite'])

const animating = ref(false)

const handleFavorite = () => {
  animating.value = true

  if (props.isFavorite) {
    emit('unfavorite', props.movie)
  } else {
    emit('favorite', props.movie)
  }
  setTimeout(() => {
    animating.value = false
  }, 300)
}
</script>