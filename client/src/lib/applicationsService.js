import { supabase } from './supabase'

export const applicationsService = {
  async getAll() {
    const { data, error } = await supabase
      .from('applications')
      .select('*')
      .order('created_at', { ascending: false })

    if (error) {
      console.error('Error fetching applications:', error)
      return null
    }

    return data
  },

  async getById(id) {
    const { data, error } = await supabase
      .from('applications')
      .select('*')
      .eq('id', id)
      .single()

    if (error) {
      console.error('Error fetching application:', error)
      return null
    }

    return data
  },

  async updateStatus(id, status) {
    const { data, error } = await supabase
      .from('applications')
      .update({ status })
      .eq('id', id)
      .select()
      .single()

    if (error) {
      console.error('Error updating application status:', error)
      return null
    }

    return data
  },

  async remove(id) {
    const { error } = await supabase
      .from('applications')
      .delete()
      .eq('id', id)

    if (error) {
      console.error('Error deleting application:', error)
      return false
    }

    return true
  }
}
