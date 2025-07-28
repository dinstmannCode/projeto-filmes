<script setup>
import { ref, watch } from 'vue';
import SearchBar from './SearchBar.vue';

const search = defineModel({ type: String });
</script>

<template>
  <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0D0D0D] shadow-md animate-slide-down">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <router-link to="/" class="text-white font-bold text-xl uppercase">Catálogo de Filmes</router-link>
      <SearchBar v-model="search" />
      <router-link to="/favorites" class="text-white font-semibold hover:text-gray-300 transition-colors uppercase">
        Meus Favoritos
      </router-link>
    </div>
  </nav>
</template>

<style scoped>
@keyframes slide-down {
  from {
    transform: translateY(-100%);
    opacity: 0;
  }

  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.animate-slide-down {
  animation: slide-down 0.6s ease-out;
}
</style>
