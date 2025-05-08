import { defineStore } from 'pinia'
import axios from '@/utils/axios'

interface AuthState {
  token: string | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: localStorage.getItem('token'),
  }),
  actions: {
    async login(email: string, password: string) {
      const response = await axios.post('/login', { email, password })
      this.token = response.data.token
      localStorage.setItem('token', this.token!)
    },
    logout() {
      this.token = null
      localStorage.removeItem('token')
    },
  },
})
