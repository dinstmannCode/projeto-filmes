<template>
  <div class="mb-6">
    <input
      v-model="query"
      type="text"
      placeholder="Que tal procurar um filme?"
      class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
    />
  </div>
</template>

<script setup>
const query = defineModel({ type: String });
</script>
