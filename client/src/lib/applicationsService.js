import api from './api'

export const applicationsService = {
  async getAll() {
    const response = await api.get('applications')
    return response.data
  },

  async getById(id) {
    const response = await api.get(`applications/${id}`)
    return response.data
  },

  async create(data) {
    const response = await api.post('applications', data)
    return response.data
  },

  async updateStatus(id, status) {
    const response = await api.put(`applications/${id}/status`, { status })
    return response.data
  },

  async remove(id) {
    await api.delete(`applications/${id}`)
    return true
  },
}
