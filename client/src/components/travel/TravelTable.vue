<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { TravelRequest } from '@/types/TravelRequest'
import StatusBadge from './StatusBadge.vue'
import TravelRequestDialog from './TravelRequestDialog.vue'
import IconSettings from '@/components/icons/IconSettings.vue'
import { useTravelStore } from '@/store/travel'
import {
  Table,
  TableHeader,
  TableBody,
  TableRow,
  TableHead,
  TableCell,
} from '@/components/ui/table'
import { Skeleton } from '@/components/ui/skeleton'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
} from '@/components/ui/dropdown-menu'

const props = defineProps<{ requests: TravelRequest[] }>()

const travelStore = useTravelStore()
const showDetailsDialog = ref(false)
const selectedRequestId = ref<number | undefined>(undefined)

onMounted(() => {
  if (travelStore.requests.length === 0) {
    travelStore.fetchAll()
  }
})

function openDetails(requestId: number) {
  selectedRequestId.value = requestId
  showDetailsDialog.value = true
}

function cancelRequest(requestId: number) {
  travelStore.updateStatus(requestId, 'cancelled')

}
async function aproveRequest(requestId: number) {
  travelStore.updateStatus(requestId, 'approved')
}
</script>

<template>
  <div>
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

      <TableBody v-if="travelStore.loading">
        <TableRow v-for="i in 5" :key="i">
          <TableCell><Skeleton class="h-4 w-24" /></TableCell>
          <TableCell><Skeleton class="h-4 w-20" /></TableCell>
          <TableCell><Skeleton class="h-4 w-20" /></TableCell>
          <TableCell><Skeleton class="h-4 w-16" /></TableCell>
          <TableCell><Skeleton class="h-8 w-8 rounded-full" /></TableCell>
        </TableRow>
      </TableBody>

      <TableBody v-else>
        <TableRow
          v-for="req in requests"
          :key="req.id"
          @click="openDetails(req.id)"
          class="hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer transition-colors duration-150"
        >
          <TableCell>{{ req.destination }}</TableCell>
          <TableCell>{{ req.departure_date }}</TableCell>
          <TableCell>{{ req.return_date }}</TableCell>
          <TableCell>
            <StatusBadge :status="req.status" />
          </TableCell>
          <TableCell @click.stop class="flex items-center space-x-2">
            <slot name="actions" :request="req" />

            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="secondary" size="icon" class="ml-2">
                  <IconSettings class="h-4 w-4" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end">
                <DropdownMenuItem>
                  <Button
                    @click="aproveRequest(req.id)"
                    variant="ghost"
                    size="sm"
                    :disabled="req.status !== 'requested'"
                    :class="{ 'opacity-50 cursor-not-allowed': req.status !== 'requested' }"
                  >
                    Aprovar
                  </Button>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <Button
                    @click="cancelRequest(req.id)"
                    variant="ghost"
                    size="sm"
                    :disabled="req.status === 'cancelled'"
                    :class="{ 'opacity-50 cursor-not-allowed': req.status === 'cancelled' }"
                  >
                    Cancelar solicitação
                  </Button>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>

    <TravelRequestDialog v-model:open="showDetailsDialog" :request-id="selectedRequestId" />
  </div>
</template>
