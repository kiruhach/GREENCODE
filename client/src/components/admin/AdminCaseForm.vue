<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { casesService, uploadCaseImage, resolveCaseImage } from '@/lib/casesService'

const router = useRouter()
const route = useRoute()
const isEdit = route.params.id && route.params.id !== 'new'

const form = ref({
  title: '',
  description: '',
  image: '',
  tags: [],
  category: '',
  full_description: '',
  result: '',
  task: '',
  solution: '',
  results: []
})

const tagInput = ref('')
const resultInput = ref('')
const loading = ref(false)
const uploading = ref(false)
const selectedFile = ref(null)
const previewUrl = ref('')

const categories = ['development', 'seo', 'design', 'content', 'analytics']

const currentPreview = computed(() => {
  return previewUrl.value || resolveCaseImage(form.value.image)
})

onMounted(async () => {
  if (isEdit) {
    const data = await casesService.getById(route.params.id)
    if (data) {
      form.value = { ...data }
    }
  }
})

onUnmounted(() => {
  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value)
  }
})

function handleFileSelect(e) {
  const file = e.target.files[0]
  if (!file) return

  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value)
  }

  selectedFile.value = file
  previewUrl.value = URL.createObjectURL(file)
}

function removeImage() {
  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value)
  }
  selectedFile.value = null
  previewUrl.value = ''
  form.value.image = ''
}

function addTag() {
  const val = tagInput.value.trim()
  if (val && !form.value.tags.includes(val)) {
    form.value.tags.push(val)
  }
  tagInput.value = ''
}

function removeTag(index) {
  form.value.tags.splice(index, 1)
}

function addResult() {
  const val = resultInput.value.trim()
  if (val) {
    if (!form.value.results) form.value.results = []
    form.value.results.push(val)
  }
  resultInput.value = ''
}

function removeResult(index) {
  form.value.results.splice(index, 1)
}

async function handleSubmit() {
  loading.value = true

  if (selectedFile.value) {
    uploading.value = true
    const url = await uploadCaseImage(selectedFile.value)
    uploading.value = false

    if (!url) {
      loading.value = false
      return
    }

    form.value.image = url
  }

  let result

  if (isEdit) {
    result = await casesService.update(route.params.id, form.value)
  } else {
    result = await casesService.create(form.value)
  }

  loading.value = false

  if (result) {
    router.push('/admin/cases')
  }
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">{{ isEdit ? 'Редактировать кейс' : 'Новый кейс' }}</h1>
    </div>

    <form class="form" @submit.prevent="handleSubmit">
      <div class="field">
        <label>Название</label>
        <input v-model="form.title" required />
      </div>

      <div class="field">
        <label>Описание (краткое)</label>
        <textarea v-model="form.description" rows="3" required></textarea>
      </div>

      <div class="field">
        <label>Категория</label>
        <select v-model="form.category">
          <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
        </select>
      </div>

      <div class="field">
        <label>Изображение</label>
        <div class="image-upload">
          <div v-if="currentPreview" class="image-preview">
            <img :src="currentPreview" alt="preview" />
            <button type="button" class="image-remove" @click="removeImage" title="Удалить">×</button>
          </div>
          <div class="upload-zone">
            <input
              type="file"
              accept="image/png,image/jpeg,image/webp,image/gif"
              class="file-input"
              @change="handleFileSelect"
              :id="'file-input-' + (isEdit ? route.params.id : 'new')"
            />
            <label :for="'file-input-' + (isEdit ? route.params.id : 'new')" class="file-label">
              {{ selectedFile ? selectedFile.name : 'Выберите файл' }}
            </label>
          </div>
        </div>
      </div>

      <div class="field">
        <label>Результат (кратко)</label>
        <input v-model="form.result" placeholder="" />
      </div>

      <div class="field">
        <label>Задача</label>
        <textarea v-model="form.task" rows="3"></textarea>
      </div>

      <div class="field">
        <label>Решение</label>
        <textarea v-model="form.solution" rows="3"></textarea>
      </div>

      <div class="field">
        <label>Полное описание</label>
        <textarea v-model="form.full_description" rows="4"></textarea>
      </div>

      <div class="field">
        <label>Теги</label>
        <div class="tag-input">
          <input v-model="tagInput" placeholder="Добавить тег" @keydown.enter.prevent="addTag" />
          <button type="button" class="btn btn-sm" @click="addTag">+</button>
        </div>
        <div class="tags">
          <span v-for="(tag, i) in form.tags" :key="i" class="tag">
            {{ tag }} <button type="button" class="tag-remove" @click="removeTag(i)">×</button>
          </span>
        </div>
      </div>

      <div class="field">
        <label>Результаты (список)</label>
        <div class="tag-input">
          <input v-model="resultInput" placeholder="Добавить результат" @keydown.enter.prevent="addResult" />
          <button type="button" class="btn btn-sm" @click="addResult">+</button>
        </div>
        <div class="tags">
          <span v-for="(r, i) in form.results" :key="i" class="tag">
            {{ r }} <button type="button" class="tag-remove" @click="removeResult(i)">×</button>
          </span>
        </div>
      </div>

      <div class="form-actions">
        <router-link to="/admin/cases" class="btn btn-cancel">Отмена</router-link>
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
.field input, .field textarea, .field select { padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; font-size: 14px; font-family: 'Roboto Mono', monospace; outline: none; transition: border-color 0.2s; }
.field input:focus, .field textarea:focus, .field select:focus { border-color: #44944A; }
.image-upload { display: flex; flex-direction: column; gap: 12px; }
.image-preview { position: relative; display: inline-block; max-width: 400px; border-radius: 12px; overflow: hidden; border: 1px solid #ddd; }
.image-preview img { width: 100%; height: 200px; object-fit: cover; display: block; }
.image-remove { position: absolute; top: 6px; right: 6px; width: 28px; height: 28px; border-radius: 50%; border: none; background: rgba(0,0,0,0.6); color: white; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1; transition: background 0.2s; }
.image-remove:hover { background: rgba(0,0,0,0.8); }
.upload-zone { display: flex; }
.file-input { display: none; }
.file-label { display: inline-flex; align-items: center; padding: 10px 20px; background: #f5f5f5; border: 1px dashed #ccc; border-radius: 10px; cursor: pointer; font-size: 13px; font-family: 'Roboto Mono', monospace; color: #666; transition: all 0.2s; width: 100%; max-width: 400px; }
.file-label:hover { border-color: #44944A; color: #44944A; background: #f0faf0; }
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
