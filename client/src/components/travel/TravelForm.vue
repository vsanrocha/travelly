<template>
  <form @submit.prevent="onSubmit" class="space-y-4">
    <div>
      <Label for="destination">Destino<Label>
      <Input id="destination" v-model="form.destination" type="text" required />
    </div>
    <div class="flex gap-4">
      <div class="flex-1">
        <Label for="departure_date">Data de Saída<Label>
        <Input id="departure_date" v-model="form.departure_date" type="date" required />
      </div>
      <div class="flex-1">
        <Label for="return_date">Data de Retorno<Label>
        <Input id="return_date" v-model="form.return_date" type="date" required />
      </div>
    </div>
    <Button type="submit" class="w-full">Solicitar Viagem</Button>
  </form>
</template>

<script setup lang="ts">
import { ref, defineEmits } from 'vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const emit = defineEmits(['submit'])
const form = ref({
  destination: '',
  departure_date: '',
  return_date: '',
})

function onSubmit() {
  emit('submit', { ...form.value })
  form.value.destination = ''
  form.value.departure_date = ''
  form.value.return_date = ''
}
</script>
