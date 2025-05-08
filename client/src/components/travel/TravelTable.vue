<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead>Destino</TableHead>
        <TableHead>Saída</TableHead>
        <TableHead>Retorno</TableHead>
        <TableHead>Status</TableHead>
        <TableHead>Ações</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="req in requests" :key="req.id">
        <TableCell>{{ req.destination }}</TableCell>
        <TableCell>{{ req.departure_date }}</TableCell>
        <TableCell>{{ req.return_date }}</TableCell>
        <TableCell>
          <StatusBadge :status="req.status" />
        </TableCell>
        <TableCell>
          <slot name="actions" :request="req" />
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>

<script setup lang="ts">
import type { TravelRequest } from '@/types/TravelRequest'
import StatusBadge from './StatusBadge.vue'
import {
  Table,
  TableHeader,
  TableBody,
  TableRow,
  TableHead,
  TableCell
} from '@/components/ui/table'

defineProps<{ requests: TravelRequest[] }>()
</script>
