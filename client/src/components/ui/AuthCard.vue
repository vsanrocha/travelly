<template>
  <Card class="rounded-2xl shadow-lg p-8 w-full max-w-md bg-white dark:bg-background">
    <slot />
  </Card>
</template>

<script setup lang="ts">
import { Card } from '@/components/ui/card'
</script>
