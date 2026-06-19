import api from './api'

export function resolveCaseImage(path) {
  if (!path) return ''
  return path
}

export async function uploadCaseImage(file) {
  const formData = new FormData()
  formData.append('file', file)

  try {
    const response = await api.post('upload', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })
    return response.data.url
  } catch {
    return null
  }
}

export async function deleteCaseImage(url) {
  try {
    await api.delete('upload', { data: { url } })
    return true
  } catch {
    return false
  }
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

  async create(caseData) {
    const response = await api.post('cases', caseData)
    return response.data
  },

  async update(id, caseData) {
    const response = await api.put(`cases/${id}`, caseData)
    return response.data
  },

  async remove(id) {
    await api.delete(`cases/${id}`)
    return true
  },
}
