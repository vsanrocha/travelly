<template>
  <DefaultLayout>
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Solicitações de Viagem</h2>
        <Button @click="showForm = true">Nova Solicitação</Button>
      </div>
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
      <Dialog v-model:open="showForm">
        <DialogContent>
          <template #title>Nova Solicitação de Viagem</template>
          <TravelForm @submit="handleCreate" />
        <DialogContent>
      <Dialog>
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import TravelTable from '@/components/travel/TravelTable.vue'
import TravelForm from '@/components/travel/TravelForm.vue'
import { useTravelStore } from '@/store/travel'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent } from '@/components/ui/dialog'

const travelStore = useTravelStore()
const showForm = ref(false)

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
