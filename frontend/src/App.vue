<template>
  <div class="min-h-screen bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
      <nav class="container mx-auto flex justify-between items-center p-4">
        <h1 class="text-xl font-bold">King Catálogo</h1>
        <div class="space-x-4">
          <RouterLink to="/" class="hover:underline">Inicio</RouterLink>
          <RouterLink to="/favorites" class="hover:underline">Meus Favoritos</RouterLink>
        </div>
      </nav>
    </header>
    <main class="container mx-auto p-4">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterView, RouterLink } from 'vue-router';
</script>
