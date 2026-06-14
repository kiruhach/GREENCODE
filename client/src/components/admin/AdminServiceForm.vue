<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { servicesService } from '@/lib/servicesService'

const router = useRouter()
const route = useRoute()
const isEdit = route.params.id && route.params.id !== 'new'

const form = ref({
  title: '',
  description: '',
  category: '',
  icon: '',
  sub_items: [],
  sort_order: 0
})

const subItemInput = ref('')
const loading = ref(false)

onMounted(async () => {
  if (isEdit) {
    const data = await servicesService.getById(route.params.id)
    if (data) {
      form.value = { ...data }
    }
  }
})

function addSubItem() {
  const val = subItemInput.value.trim()
  if (val && !form.value.sub_items.includes(val)) {
    form.value.sub_items.push(val)
  }
  subItemInput.value = ''
}

function removeSubItem(index) {
  form.value.sub_items.splice(index, 1)
}

async function handleSubmit() {
  loading.value = true
  let result

  if (isEdit) {
    result = await servicesService.update(route.params.id, form.value)
  } else {
    result = await servicesService.create(form.value)
  }

  loading.value = false

  if (result) {
    router.push('/admin/services')
  }
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">{{ isEdit ? 'Редактировать услугу' : 'Новая услуга' }}</h1>
    </div>

    <form class="form" @submit.prevent="handleSubmit">
      <div class="field">
        <label>Название</label>
        <input v-model="form.title" required />
      </div>

      <div class="field">
        <label>Описание</label>
        <textarea v-model="form.description" rows="3" required></textarea>
      </div>

      <div class="field">
        <label>Категория</label>
        <input v-model="form.category" placeholder="Разработка сайтов" required />
      </div>

      <div class="field">
        <label>Иконка (имя файла без .svg)</label>
        <input v-model="form.icon" placeholder="create_site" />
      </div>

      <div class="field">
        <label>Порядок сортировки</label>
        <input v-model.number="form.sort_order" type="number" />
      </div>

      <div class="field">
        <label>Под-услуги</label>
        <div class="tag-input">
          <input v-model="subItemInput" placeholder="Добавить" @keydown.enter.prevent="addSubItem" />
          <button type="button" class="btn btn-sm" @click="addSubItem">+</button>
        </div>
        <div class="tags">
          <span v-for="(item, i) in form.sub_items" :key="i" class="tag">
            {{ item }} <button type="button" class="tag-remove" @click="removeSubItem(i)">×</button>
          </span>
        </div>
      </div>

      <div class="form-actions">
        <router-link to="/admin/services" class="btn btn-cancel">Отмена</router-link>
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
.tag-input { display: flex; gap: 8px; }
.tag-input input { flex: 1; }
.tags { display: flex; flex-wrap: wrap; gap: 8px; }
.tag { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #E8F5E9; border-radius: 20px; font-size: 13px; font-family: 'Roboto Mono', monospace; color: #2E7D32; }
.tag-remove { background: none; border: none; color: #2E7D32; cursor: pointer; font-size: 16px; padding: 0; line-height: 1; }
.form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 8px; }
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-family: 'Roboto Mono', monospace; border: none; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-primary { background: #44944A; color: white; }
.btn-primary:hover { background: #3a7d3d; }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-cancel { background: #f0f0f0; color: #666; }
.btn-cancel:hover { background: #e0e0e0; }
.btn-sm { padding: 8px 14px; font-size: 13px; background: #f0f0f0; color: #333; }
.btn-sm:hover { background: #e0e0e0; }
</style>
