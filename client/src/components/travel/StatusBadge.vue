<template>
  <Badge :variant="variant">
    {{ statusLabel }}
  </Badge>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Badge } from '@/components/ui/badge'

const props = defineProps<{ status: string }>()

const variant = computed(() => {
  switch (props.status) {
    case 'approved':
      return 'success'
    case 'canceled':
      return 'destructive'
    default:
      return 'secondary'
  }
})

const statusLabel = computed(() => {
  switch (props.status) {
    case 'approved':
      return 'Aprovada'
    case 'canceled':
      return 'Cancelada'
    default:
      return 'Pendente'
  }
})
</script>
