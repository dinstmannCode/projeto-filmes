<template>
  <input v-model="query" type="text" placeholder="Que tal procurar um filme?"
    class="w-full max-w-lg px-4 py-2 rounded-md bg-[#1a1a1a] text-white placeholder-gray-400 border border-[#6C2BD9] focus:outline-none focus:ring-2 focus:ring-[#6C2BD9] shadow-sm" />
</template>

<script setup>
const query = defineModel({ type: String });
</script>
