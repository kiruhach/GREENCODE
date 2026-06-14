<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { signIn } from '@/lib/auth'

const router = useRouter()
const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

async function handleLogin() {
  error.value = ''
  loading.value = true
  const result = await signIn(email.value, password.value)
  loading.value = false

  if (result.error) {
    error.value = 'Неверный email или пароль'
    return
  }

  router.replace('/admin')
}
</script>

<template>
  <div class="login-page">
    <div class="login-card">
      <div class="login-header">
        <router-link to="/" class="login-logo">GREENCODE</router-link>
        <p class="login-subtitle">Вход в панель управления</p>
      </div>
      <form class="login-form" @submit.prevent="handleLogin">
        <div class="field">
          <label for="email">Email</label>
          <input id="email" v-model="email" type="email" placeholder="admin@greencode.ru" required />
        </div>
        <div class="field">
          <label for="password">Пароль</label>
          <input id="password" v-model="password" type="password" placeholder="••••••••" required />
        </div>
        <p v-if="error" class="error-msg">{{ error }}</p>
        <button type="submit" class="login-btn" :disabled="loading">
          {{ loading ? 'Вход...' : 'Войти' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-page {
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  width: 100%;
  max-width: 480px;
  background: white;
  border-radius: 24px;
  padding: 52px 48px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.login-logo {
  display: block;
  color: #004524;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 28px;
  font-weight: 700;
  text-decoration: none;
  letter-spacing: 3px;
}

.login-subtitle {
  color: #666;
  font-size: 15px;
  font-family: 'Roboto Mono', monospace;
  margin-top: 10px;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.field label {
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  color: #333;
  font-weight: 500;
}

.field input {
  padding: 14px 18px;
  border: 1px solid #ddd;
  border-radius: 14px;
  font-size: 15px;
  font-family: 'Roboto Mono', monospace;
  outline: none;
  transition: border-color 0.2s;
}

.field input:focus {
  border-color: #44944A;
}

.error-msg {
  color: #e74c3c;
  font-size: 13px;
  font-family: 'Roboto Mono', monospace;
  text-align: center;
}

.login-btn {
  padding: 16px;
  background: #44944A;
  color: white;
  border: none;
  border-radius: 14px;
  font-size: 17px;
  font-family: 'Roboto Mono', monospace;
  cursor: pointer;
  transition: background 0.2s;
}

.login-btn:hover {
  background: #3a7d3d;
}

.login-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
