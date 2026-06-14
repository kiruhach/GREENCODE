import { supabase } from './supabase'

export const reviewsService = {
  async getAll() {
    const { data, error } = await supabase
      .from('reviews')
      .select('*')
      .order('created_at', { ascending: false })

    if (error) {
      console.error('Error fetching reviews:', error)
      return null
    }

    return data
  },

  async getById(id) {
    const { data, error } = await supabase
      .from('reviews')
      .select('*')
      .eq('id', id)
      .single()

    if (error) {
      console.error('Error fetching review:', error)
      return null
    }

    return data
  },

  async getLatest(limit = 2) {
    const { data, error } = await supabase
      .from('reviews')
      .select('*')
      .order('created_at', { ascending: false })
      .limit(limit)

    if (error) {
      console.error('Error fetching latest reviews:', error)
      return null
    }

    return data
  },

  async create(review) {
    const { data, error } = await supabase
      .from('reviews')
      .insert(review)
      .select()

    if (error) {
      console.error('Error creating review:', error)
      return null
    }

    return data
  },

  async update(id, review) {
    const { data, error } = await supabase
      .from('reviews')
      .update(review)
      .eq('id', id)
      .select()
      .single()

    if (error) {
      console.error('Error updating review:', error)
      return null
    }

    return data
  },

  async remove(id) {
    const { error } = await supabase
      .from('reviews')
      .delete()
      .eq('id', id)

    if (error) {
      console.error('Error deleting review:', error)
      return false
    }

    return true
  }
}
