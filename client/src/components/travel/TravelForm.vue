<script setup lang="ts">
import { defineEmits } from 'vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { useForm, useField } from 'vee-validate'
import * as yup from 'yup'

const emit = defineEmits(['submit'])

const schema = yup.object({
  destination: yup.string().required('Destino é obrigatório'),
  departure_date: yup.string().required('Data de saída é obrigatória'),
  return_date: yup.string()
    .required('Data de retorno é obrigatória')
    .test('is-after-departure', 'Data de retorno deve ser após a data de saída', function(value) {
      const { departure_date } = this.parent
      if (!value || !departure_date) return true
      return new Date(value) >= new Date(departure_date)
    })
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema: schema,
  initialValues: {
    destination: '',
    departure_date: '',
    return_date: ''
  }
})

const { value: destination } = useField('destination')
const { value: departure_date } = useField('departure_date')
const { value: return_date } = useField('return_date')

const onSubmit = handleSubmit((values) => {
  emit('submit', values)
  resetForm()
})
</script>

<template>
  <form @submit.prevent="onSubmit" class="space-y-4">
    <div>
      <Label for="destination">Destino</Label>
      <Input id="destination" v-model="destination" type="text" :class="{ 'border-red-500': errors.destination }" />
      <p v-if="errors.destination" class="text-red-500 text-sm mt-1">{{ errors.destination }}</p>
    </div>
    <div class="flex gap-4">
      <div class="flex-1">
        <Label for="departure_date">Data de Saída</Label>
        <Input id="departure_date" v-model="departure_date" type="date" :class="{ 'border-red-500': errors.departure_date }" />
        <p v-if="errors.departure_date" class="text-red-500 text-sm mt-1">{{ errors.departure_date }}</p>
      </div>
      <div class="flex-1">
        <Label for="return_date">Data de Retorno</Label>
        <Input id="return_date" v-model="return_date" type="date" :class="{ 'border-red-500': errors.return_date }" />
        <p v-if="errors.return_date" class="text-red-500 text-sm mt-1">{{ errors.return_date }}</p>
      </div>
    </div>
    <Button type="submit" class="w-full">Solicitar Viagem</Button>
  </form>
</template>
