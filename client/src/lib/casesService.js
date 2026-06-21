import api from './api'

export function resolveCaseImage(path) {
  if (!path) return ''
  return path
}

export const casesService = {
  async getAll() {
    const response = await api.get('cases')
    return response.data
  },

  async getById(id) {
    const response = await api.get(`cases/${id}`)
    return response.data
  },

  async getByCategory(category) {
    const response = await api.get('cases', { params: { category } })
    return response.data
  },
}
