<template>
  <div class="min-h-screen bg-gray-50 dark:bg-background">
    <Header />
    <main class="pt-20 px-4 max-w-7xl mx-auto">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
import Header from '@/components/ui/Header.vue'
</script>
