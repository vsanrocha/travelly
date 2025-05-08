<template>
  <header class="fixed top-0 left-0 w-full bg-white dark:bg-background shadow z-30">
    <div class="flex items-center justify-between h-16 px-6">
      <div class="flex items-center gap-2">
        <span class="font-bold text-lg tracking-tight text-indigo-600">Travelly</span>
      </div>
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <Button
            class="rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 p-2 focus:outline-none"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-600 dark:text-gray-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuItem @click="goProfile">Profile</DropdownMenuItem>
          <DropdownMenuItem @click="goSettings">Settings</DropdownMenuItem>
          <DropdownMenuSeparator />
          <DropdownMenuItem @click="logout" class="text-red-600">Logout</DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  </header>
</template>

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
