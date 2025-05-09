<script setup lang="ts">
import { computed } from 'vue'
import { Badge } from '@/components/ui/badge'

const props = defineProps<{ status: string }>()

const variant = computed(() => {
  switch (props.status) {
    case 'approved':
      return 'success'
    case 'cancelled':
      return 'destructive'
    default:
      return 'default'
  }
})

const statusLabel = computed(() => {
  switch (props.status) {
    case 'approved':
      return 'Aprovada'
    case 'cancelled':
      return 'Cancelada'
    default:
      return 'Pendente'
  }
})
</script>

<template>
  <Badge :variant="variant">
    {{ statusLabel }}
  </Badge>
</template>
