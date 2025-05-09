import { defineStore } from 'pinia'
import axios from '@/utils/axios'
import type { TravelRequest } from '@/types/TravelRequest'
import { toast } from 'vue-sonner'

interface TravelState {
  requests: TravelRequest[]
  loading: boolean
}

export const useTravelStore = defineStore('travel', {
  state: (): TravelState => ({
    requests: [],
    loading: false,
  }),
  actions: {
    async fetchAll(params?: Record<string, string>) {
      console.log(params)
      this.loading = true
      try {
        const { data } = await axios.get('/travel-requests', { params })
        this.requests = data
      } catch (error) {
        console.error('Erro ao buscar solicitações:', error)
        toast.error('Erro ao buscar solicitações')
      } finally {
        this.loading = false
      }
    },
    async create(payload: Partial<TravelRequest>) {
      try {
        const { data } = await axios.post('/travel-requests', payload)
        this.requests.push(data)
        toast.success('Solicitação criada com sucesso')
      } catch (error) {
        console.error('Erro ao criar solicitação:', error)
        toast.error('Erro ao criar solicitação')
      }
    },
    async updateStatus(id: number, status: string) {
      try {
        const { data } = await axios.patch(`/travel-requests/${id}/status`, { status })
        const idx = this.requests.findIndex(r => r.id === id)
        if (idx !== -1) this.requests[idx] = data
        toast.success('Status atualizado com sucesso')
      } catch (error) {
        console.error('Erro ao atualizar status:', error)
        toast.error('Erro ao atualizar status')
      }
    },
    async fetchById(id: number): Promise<TravelRequest | undefined> {
      try {
        const { data } = await axios.get(`/travel-requests/${id}`)
        return data
      } catch (error) {
        console.error('Erro ao buscar solicitação:', error)
        toast.error('Erro ao buscar solicitação')
        return undefined
      }
    },
  },
})
