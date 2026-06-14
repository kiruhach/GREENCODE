<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { reviewsService } from '@/lib/reviewsService'

const router = useRouter()
const route = useRoute()
const isEdit = route.params.id && route.params.id !== 'new'

const form = ref({
  name: '',
  role: '',
  text: '',
  initials: ''
})

const loading = ref(false)

onMounted(async () => {
  if (isEdit) {
    const data = await reviewsService.getById(route.params.id)
    if (data) {
      form.value = { ...data }
    }
  }
})

async function handleSubmit() {
  loading.value = true
  let result

  if (isEdit) {
    result = await reviewsService.update(route.params.id, form.value)
  } else {
    result = await reviewsService.create(form.value)
  }

  loading.value = false

  if (result) {
    router.push('/admin/reviews')
  }
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">{{ isEdit ? 'Редактировать отзыв' : 'Новый отзыв' }}</h1>
    </div>

    <form class="form" @submit.prevent="handleSubmit">
      <div class="field">
        <label>Имя</label>
        <input v-model="form.name" required />
      </div>

      <div class="field">
        <label>Должность</label>
        <input v-model="form.role" placeholder="CEO компании" />
      </div>

      <div class="field">
        <label>Инициалы (для аватарки)</label>
        <input v-model="form.initials" placeholder="АК" maxlength="2" />
      </div>

      <div class="field">
        <label>Текст отзыва</label>
        <textarea v-model="form.text" rows="5" required></textarea>
      </div>

      <div class="form-actions">
        <router-link to="/admin/reviews" class="btn btn-cancel">Отмена</router-link>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          {{ loading ? 'Сохранение...' : 'Сохранить' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.page { max-width: 700px; }
.page-header { margin-bottom: 24px; }
.page-title { font-size: 28px; font-family: 'Space Grotesk', sans-serif; color: #004524; }
.form { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; flex-direction: column; gap: 20px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.field label { font-size: 13px; font-family: 'Roboto Mono', monospace; color: #333; font-weight: 500; }
.field input, .field textarea { padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; font-size: 14px; font-family: 'Roboto Mono', monospace; outline: none; transition: border-color 0.2s; }
.field input:focus, .field textarea:focus { border-color: #44944A; }
.form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 8px; }
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-family: 'Roboto Mono', monospace; border: none; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-primary { background: #44944A; color: white; }
.btn-primary:hover { background: #3a7d3d; }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-cancel { background: #f0f0f0; color: #666; }
.btn-cancel:hover { background: #e0e0e0; }
</style>
