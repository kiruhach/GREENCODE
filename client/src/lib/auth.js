import { ref } from 'vue'
import api from './api'

export const user = ref(null)

export async function getSession() {
  const token = localStorage.getItem('admin_token')
  if (!token) {
    user.value = null
    return null
  }

  try {
    const response = await api.get('auth/user')
    user.value = response.data
    return response.data
  } catch {
    user.value = null
    localStorage.removeItem('admin_token')
    return null
  }
}

export async function signIn(email, password) {
  try {
    const response = await api.post('auth/login', { email, password })
    localStorage.setItem('admin_token', response.data.token)
    user.value = response.data.user
    return { data: response.data }
  } catch (error) {
    return { error: error.response?.data?.errors?.email?.[0] || 'Ошибка входа' }
  }
}

export async function signOut() {
  try {
    await api.post('auth/logout')
  } catch {
    // ignore
  }
  localStorage.removeItem('admin_token')
  user.value = null
}
