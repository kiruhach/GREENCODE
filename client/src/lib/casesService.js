import { supabase } from './supabase'

const caseImages = import.meta.glob('/src/assets/images/*_case.webp', {
  eager: true,
  query: '?url',
  import: 'default'
})

export function resolveCaseImage(path) {
  if (!path) return ''
  return caseImages[path] || path
}

export async function uploadCaseImage(file) {
  const ext = file.name.split('.').pop()
  const fileName = `${Date.now()}_${Math.random().toString(36).slice(2)}.${ext}`

  const { error } = await supabase.storage
    .from('case-images')
    .upload(fileName, file, {
      cacheControl: '3600',
      upsert: false
    })

  if (error) {
    console.error('Error uploading image:', error)
    return null
  }

  const { data: { publicUrl } } = supabase.storage
    .from('case-images')
    .getPublicUrl(fileName)

  return publicUrl
}

export async function deleteCaseImage(url) {
  if (!url || !url.includes('case-images')) return true

  const fileName = url.split('/').pop()

  const { error } = await supabase.storage
    .from('case-images')
    .remove([fileName])

  if (error) {
    console.error('Error deleting image:', error)
    return false
  }

  return true
}

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
  },

  async create(caseData) {
    const { data, error } = await supabase
      .from('cases')
      .insert(caseData)
      .select()
      .single()

    if (error) {
      console.error('Error creating case:', error)
      return null
    }

    return data
  },

  async update(id, caseData) {
    const { data, error } = await supabase
      .from('cases')
      .update(caseData)
      .eq('id', id)
      .select()
      .single()

    if (error) {
      console.error('Error updating case:', error)
      return null
    }

    return data
  },

  async remove(id) {
    const { error } = await supabase
      .from('cases')
      .delete()
      .eq('id', id)

    if (error) {
      console.error('Error deleting case:', error)
      return false
    }

    return true
  }
}