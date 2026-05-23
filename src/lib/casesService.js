import { supabase } from './supabase'

export const casesService = {
  async getAll() {
    const { data, error } = await supabase
      .from('cases')
      .select('*')
      .order('created_at', { ascending: false })

    if (error) {
      console.error('Error fetching cases:', error)
      return null
    }

    return data
  },

  async getById(id) {
    const { data, error } = await supabase
      .from('cases')
      .select('*')
      .eq('id', id)
      .single()

    if (error) {
      console.error('Error fetching case:', error)
      return null
    }

    return data
  },

  async getByCategory(category) {
    const { data, error } = await supabase
      .from('cases')
      .select('*')
      .eq('category', category)

    if (error) {
      console.error('Error fetching cases:', error)
      return null
    }

    return data
  }
}