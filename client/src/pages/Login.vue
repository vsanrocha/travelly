<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { useForm, useField } from 'vee-validate'
import * as yup from 'yup'

const router = useRouter()
const authStore = useAuthStore()
const loading = ref(false)
const error = ref('')

const schema = yup.object({
  email: yup.string().email('Email inválido').required('Email é obrigatório'),
  password: yup
    .string()
    .required('Senha é obrigatória')
    .min(6, 'Senha deve ter pelo menos 6 caracteres'),
})

const { handleSubmit, errors } = useForm({
  validationSchema: schema,
})

const { value: email } = useField('email')
const { value: password } = useField('password')

const onSubmit = handleSubmit(async (values) => {
  loading.value = true
  error.value = ''
  try {
    await authStore.login(values.email, values.password)
    router.push('/')
  } catch (e: any) {
    error.value = e?.response?.data?.message || 'Falha no login'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <AuthLayout>
    <form @submit.prevent="onSubmit" class="space-y-6">
      <h1 class="text-2xl font-bold text-center mb-2">Entrar</h1>
      <div>
        <Label for="email">Email</Label>
        <Input
          id="email"
          v-model="email"
          type="email"
          autocomplete="username"
          :class="[errors.email ? 'border-red-500' : '', 'rounded-2xl shadow-sm']"
        />
        <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
      </div>
      <div>
        <Label for="password">Senha</Label>
        <Input
          id="password"
          v-model="password"
          type="password"
          autocomplete="current-password"
          :class="[errors.password ? 'border-red-500' : '', 'rounded-2xl shadow-sm']"
        />
        <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
      </div>
      <Button type="submit" class="w-full rounded-2xl shadow-md" :disabled="loading">Entrar</Button>
      <p v-if="error" class="text-red-600 text-sm text-center">{{ error }}</p>
    </form>
  </AuthLayout>
</template>
