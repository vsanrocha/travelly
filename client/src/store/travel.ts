import { defineStore } from 'pinia'
import axios from '@/utils/axios'
import type { TravelRequest } from '@/types/TravelRequest'

interface TravelState {
  requests: TravelRequest[]
}

export const useTravelStore = defineStore('travel', {
  state: (): TravelState => ({
    requests: [],
  }),
  actions: {
    async fetchAll() {
      const { data } = await axios.get('/travel-requests')
      this.requests = data
    },
    async create(payload: Partial<TravelRequest>) {
      const { data } = await axios.post('/travel-requests', payload)
      this.requests.push(data)
    },
    async updateStatus(id: number, status: string) {
      const { data } = await axios.patch(`/travel-requests/${id}/status`, { status })
      const idx = this.requests.findIndex(r => r.id === id)
      if (idx !== -1) this.requests[idx] = data
    },
    async fetchById(id: number): Promise<TravelRequest> {
      const { data } = await axios.get(`/travel-requests/${id}`)
      return data
    },
  },
})
