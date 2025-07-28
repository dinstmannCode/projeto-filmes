<template>
  <div class="min-h-screen bg-[#0D0D0D] text-[#F0F0F0] font-sans">
    <router-view />
  </div>
</template>

<script setup>
</script>

<style>
/* Reset global */
body {
  margin: 0;
  padding: 0;
  font-family: 'Inter', sans-serif;
  background-color: #0D0D0D;
  color: #F0F0F0;
}
</style>
