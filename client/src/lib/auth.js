import { ref } from 'vue'
import { supabase } from './supabase'

export const user = ref(null)

export async function getSession() {
  const { data: { session } } = await supabase.auth.getSession()
  user.value = session?.user ?? null
  return session
}

export async function signIn(email, password) {
  const { data, error } = await supabase.auth.signInWithPassword({ email, password })
  if (error) return { error }
  user.value = data.user
  return { data }
}

export async function signOut() {
  await supabase.auth.signOut()
  user.value = null
}
