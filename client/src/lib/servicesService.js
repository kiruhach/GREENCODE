import api from './api'

export function resolveServiceIcon(iconName) {
  if (!iconName) return ''
  const icons = import.meta.glob('/src/assets/icons/*.svg', {
    eager: true,
    query: '?url',
    import: 'default'
  })
  const path = `/src/assets/icons/${iconName}.svg`
  return icons[path] || path
}

export const servicesService = {
  async getAll() {
    const response = await api.get('services')
    return response.data
  },

  async getById(id) {
    const response = await api.get(`services/${id}`)
    return response.data
  },

  async getDetails(serviceId) {
    const response = await api.get(`services/${serviceId}/details`)
    return response.data
  },

  async getAllDetails() {
    const response = await api.get('services/details/all')
    return response.data
  },

  async create(serviceData) {
    const response = await api.post('services', serviceData)
    return response.data
  },

  async update(id, serviceData) {
    const response = await api.put(`services/${id}`, serviceData)
    return response.data
  },

  async remove(id) {
    await api.delete(`services/${id}`)
    return true
  },
}
