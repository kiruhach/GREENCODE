import api from './api'

export const applicationsService = {
  async create(data) {
    const response = await api.post('applications', data)
    return response.data
  },
}
