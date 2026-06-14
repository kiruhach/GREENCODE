import { supabase } from './supabase'

const serviceIcons = import.meta.glob('/src/assets/icons/*.svg', {
  eager: true,
  query: '?url',
  import: 'default'
})

export function resolveServiceIcon(iconName) {
  if (!iconName) return ''
  const path = `/src/assets/icons/${iconName}.svg`
  return serviceIcons[path] || path
}

export const servicesService = {
  async getAll() {
    const { data, error } = await supabase
      .from('services')
      .select('*')
      .order('sort_order', { ascending: true })

    if (error) {
      console.error('Error fetching services:', error)
      return null
    }

    return data
  },

  async getById(id) {
    const { data, error } = await supabase
      .from('services')
      .select('*')
      .eq('id', id)
      .single()

    if (error) {
      console.error('Error fetching service:', error)
      return null
    }

    return data
  },

  async getDetails(serviceId) {
    const { data, error } = await supabase
      .from('service_details')
      .select('*')
      .eq('service_id', serviceId)
      .order('sort_order', { ascending: true })

    if (error) {
      console.error('Error fetching service details:', error)
      return null
    }

    return data
  },

  async getAllDetails() {
    const { data, error } = await supabase
      .from('service_details')
      .select('*')
      .order('sort_order', { ascending: true })

    if (error) {
      console.error('Error fetching all details:', error)
      return null
    }

    return data
  },

  async create(serviceData) {
    const { data, error } = await supabase
      .from('services')
      .insert(serviceData)
      .select()
      .single()

    if (error) {
      console.error('Error creating service:', error)
      return null
    }

    return data
  },

  async update(id, serviceData) {
    const { data, error } = await supabase
      .from('services')
      .update(serviceData)
      .eq('id', id)
      .select()
      .single()

    if (error) {
      console.error('Error updating service:', error)
      return null
    }

    return data
  },

  async remove(id) {
    const { error } = await supabase
      .from('services')
      .delete()
      .eq('id', id)

    if (error) {
      console.error('Error deleting service:', error)
      return false
    }

    return true
  },

  async createDetail(detail) {
    const { data, error } = await supabase
      .from('service_details')
      .insert(detail)
      .select()
      .single()

    if (error) {
      console.error('Error creating service detail:', error)
      return null
    }

    return data
  },

  async updateDetail(id, detail) {
    const { data, error } = await supabase
      .from('service_details')
      .update(detail)
      .eq('id', id)
      .select()
      .single()

    if (error) {
      console.error('Error updating service detail:', error)
      return null
    }

    return data
  },

  async removeDetail(id) {
    const { error } = await supabase
      .from('service_details')
      .delete()
      .eq('id', id)

    if (error) {
      console.error('Error deleting service detail:', error)
      return false
    }

    return true
  }
}
