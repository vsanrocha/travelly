<script setup lang="ts">
import { ref, watch } from 'vue'
import type { TravelRequest } from '@/types/TravelRequest'
import { useTravelStore } from '@/store/travel'
import StatusBadge from './StatusBadge.vue'
import { Skeleton } from '@/components/ui/skeleton'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'

const props = defineProps<{
  open: boolean
  requestId?: number
}>()

const emit = defineEmits<{
  'update:open': [value: boolean]
}>()

const travelStore = useTravelStore()
const loading = ref(false)
const requestDetails = ref<TravelRequest | null>(null)
const error = ref<string | null>(null)

watch(
  () => [props.open, props.requestId],
  async ([open, id]) => {
    if (open && id) {
      loading.value = true
      error.value = null
      requestDetails.value = null

      try {
        requestDetails.value = await travelStore.fetchById(id)
      } catch (err) {
        console.error('Falha ao buscar detalhes da solicitação:', err)
        error.value = 'Erro ao carregar os detalhes'
      } finally {
        loading.value = false
      }
    }
  },
  { immediate: true }
)
</script>

<template>
  <Dialog :open="open" @update:open="$emit('update:open', $event)">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Detalhes da Solicitação</DialogTitle>
        <DialogDescription v-if="!loading">
          Informações detalhadas da sua solicitação de viagem.
        </DialogDescription>
        <DialogDescription v-else>
          Carregando detalhes...
        </DialogDescription>
      </DialogHeader>


      <div v-if="error" class="py-4 text-center text-red-500">
        Não foi possível carregar os detalhes da solicitação.
      </div>

      <div v-else class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label class="text-right">Solicitante:</Label>
          <Skeleton v-if="loading" class="h-4 w-full col-span-3" />
          <span v-else class="col-span-3">{{ requestDetails.requester_name }}</span>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label class="text-right">Destino:</Label>
          <Skeleton v-if="loading" class="h-4 w-full col-span-3" />
          <span v-else class="col-span-3">{{ requestDetails.destination }}</span>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label class="text-right">Saída:</Label>
          <Skeleton v-if="loading" class="h-4 w-full col-span-3" />
          <span v-else class="col-span-3">{{ requestDetails.departure_date }}</span>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label class="text-right">Retorno:</Label>
          <Skeleton v-if="loading" class="h-4 w-full col-span-3" />
          <span v-else class="col-span-3">{{ requestDetails.return_date }}</span>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label class="text-right">Status:</Label>
          <Skeleton v-if="loading" class="h-4 w-full col-span-3" />
          <StatusBadge v-else :status="requestDetails.status" class="col-span-3" />
        </div>
      </div>

      <DialogFooter>
        <Button @click="$emit('update:open', false)">Fechar</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
