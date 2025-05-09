<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu'
import { Button } from '@/components/ui/button'
import IconPerson from '@/components/icons/IconPerson.vue'

const router = useRouter()
const authStore = useAuthStore()

function goProfile() {
  router.push('/profile')
}
function goSettings() {
  router.push('/settings')
}
function logout() {
  authStore.logout()
  router.push('/login')
}
</script>

<template>
  <header class="fixed top-0 left-0 w-full bg-white dark:bg-background shadow z-30">
    <div class="flex items-center justify-between h-16 px-6">
      <div class="flex items-center gap-2">
        <span class="font-bold text-lg tracking-tight text-indigo-600">Travelly</span>
      </div>
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <Button
            class="rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 p-2 focus:outline-none"
          >
           <IconPerson />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuItem @click="goProfile"
            ><Button variant="ghost">Profile</Button></DropdownMenuItem
          >
          <DropdownMenuItem @click="goSettings"
            ><Button variant="ghost">Settings</Button></DropdownMenuItem
          >
          <DropdownMenuSeparator />
          <DropdownMenuItem @click="logout" class="text-red-600"
            ><Button variant="ghost">Logout</Button></DropdownMenuItem
          >
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  </header>
</template>
