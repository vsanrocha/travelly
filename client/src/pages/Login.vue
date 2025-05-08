<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-50 dark:bg-background">
    <form @submit.prevent="onSubmit" class="bg-white rounded-lg shadow-md p-8 w-full max-w-sm space-y-6">
      <h1 class="text-xl font-semibold text-center">Entrar</h1>
      <div>
        <Label for="email">Email</Label>
        <Input id="email" v-model="email" type="email" autocomplete="username" required />
      </div>
      <div>
        <Label for="password">Senha</Label>
        <Input id="password" v-model="password" type="password" autocomplete="current-password" required />
      </div>
      <Button type="submit" class="w-full" :disabled="loading">Entrar</Button>
      <p v-if="error" class="text-red-600 text-sm text-center">{{ error }}</p>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const router = useRouter()
const authStore = useAuthStore()
const email = ref('')
const password = ref('')
const loading = ref(false)
const error = ref('')

async function onSubmit() {
  loading.value = true
  error.value = ''
  try {
    await authStore.login(email.value, password.value)
    router.push('/')
  } catch (e: any) {
    error.value = e?.response?.data?.message || 'Falha no login'
  } finally {
    loading.value = false
  }
}
</script>
