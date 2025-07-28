<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full animate-fadeIn">
      <h2 class="text-black text-lg font-semibold mb-4">{{ title }}</h2>
      <div class="flex justify-end space-x-4">
        <button @click="$emit('cancel')" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500 cursor-pointer">
          Não
        </button>
        <button @click="$emit('confirm')" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer">
          Sim
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String
})
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}
</style>
