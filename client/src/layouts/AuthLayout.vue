<script setup lang="ts">
import AuthCard from '@/components/ui/AuthCard.vue'
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-background dark:to-background">
    <AuthCard>
      <slot />
    </AuthCard>
  </div>
</template>
