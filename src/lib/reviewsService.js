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
  }
}
