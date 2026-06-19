import api from './api'

export const reviewsService = {
  async getAll() {
    const response = await api.get('reviews')
    return response.data
  },

  async getById(id) {
    const response = await api.get(`reviews/${id}`)
    return response.data
  },

  async getLatest(limit = 2) {
    const response = await api.get('reviews/latest', { params: { limit } })
    return response.data
  },

  async create(review) {
    const response = await api.post('reviews', review)
    return response.data
  },

  async update(id, review) {
    const response = await api.put(`reviews/${id}`, review)
    return response.data
  },

  async remove(id) {
    await api.delete(`reviews/${id}`)
    return true
  },
}
