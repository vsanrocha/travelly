<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import TravelTable from '@/components/travel/TravelTable.vue'
import TravelForm from '@/components/travel/TravelForm.vue'
import { useTravelStore } from '@/store/travel'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent } from '@/components/ui/dialog'

const FILTERS = {
  status: undefined,
  start_date: undefined,
  end_date: undefined,
  destination: undefined,
}

const travelStore = useTravelStore()
const showForm = ref(false)

const filters = ref({...FILTERS})

function fetchFiltered() {
  travelStore.fetchAll({...filters.value})
}

function clearFilters() {
  filters.value = {...FILTERS}
  fetchFiltered()
}

onMounted(() => {
  travelStore.fetchAll()
})

async function handleCreate(payload: any) {
  await travelStore.create(payload)
  showForm.value = false
}

async function updateStatus(id: number, status: string) {
  await travelStore.updateStatus(id, status)
}
</script>

<template>
  <AppLayout>
    <div class="container mx-auto py-8">
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">Solicitações de Viagem</h2>
        <Button class="w-full sm:w-auto" @click="showForm = true">Nova Solicitação</Button>
      </div>
      <div class="flex flex-col sm:flex-row flex-wrap gap-4 mb-6 items-end">
        <div class="w-full sm:w-auto">
          <label class="block text-sm font-medium mb-1">Status</label>
          <select v-model="filters.status" @change="fetchFiltered" class="border rounded px-2 py-1 w-full">
            <option :value="undefined">Todos</option>
            <option value="requested">Pendente</option>
            <option value="approved">Aprovado</option>
            <option value="cancelled">Cancelado</option>
          </select>
        </div>
        <div class="w-full sm:w-auto">
          <label class="block text-sm font-medium mb-1">Data Inicial</label>
          <input type="date" v-model="filters.start_date" @change="fetchFiltered" class="border rounded px-2 py-1 w-full" />
        </div>
        <div class="w-full sm:w-auto">
          <label class="block text-sm font-medium mb-1">Data Final</label>
          <input type="date" v-model="filters.end_date" @change="fetchFiltered" class="border rounded px-2 py-1 w-full" />
        </div>
        <div class="w-full sm:w-auto">
          <label class="block text-sm font-medium mb-1">Destino</label>
          <input type="text" v-model="filters.destination" @input="fetchFiltered" placeholder="Destino" class="border rounded px-2 py-1 w-full" />
        </div>
        <Button variant="secondary" class="w-full sm:w-auto" @click="clearFilters">Limpar Filtros</Button>
      </div>
      <div class="overflow-x-auto">
        <TravelTable :requests="travelStore.requests">
          <template #actions="{ request }">
            <Button
              v-if="request.status === 'pending'"
              size="sm"
              variant="success"
              class="mr-2"
              @click="() => updateStatus(request.id, 'approved')"
            >Aprovar</Button>
            <Button
              v-if="request.status === 'pending'"
              size="sm"
              variant="destructive"
              @click="() => updateStatus(request.id, 'canceled')"
            >Cancelar</Button>
          </template>
        </TravelTable>
      </div>
      <Dialog v-model:open="showForm">
        <DialogContent>
          <template #title>Nova Solicitação de Viagem</template>
          <TravelForm @submit="handleCreate" />
        </DialogContent>
      </Dialog>
    </div>
  </AppLayout>
</template>
