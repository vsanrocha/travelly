<template>
  <AuthLayout>
    <form @submit.prevent="onSubmit" class="space-y-6">
      <h1 class="text-2xl font-bold text-center mb-2">Entrar</h1>
      <div>
        <Label for="email">Email</Label>
        <Input id="email" v-model="email" type="email" autocomplete="username" required class="rounded-2xl shadow-sm" />
      </div>
      <div>
        <Label for="password">Senha</Label>
        <Input id="password" v-model="password" type="password" autocomplete="current-password" required class="rounded-2xl shadow-sm" />
      </div>
      <Button type="submit" class="w-full rounded-2xl shadow-md" :disabled="loading">Entrar</Button>
      <p v-if="error" class="text-red-600 text-sm text-center">{{ error }}</p>
    </form>
  </AuthLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import AuthLayout from '@/layouts/AuthLayout.vue'

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
