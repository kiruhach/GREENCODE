<script setup>
import { ref, onMounted } from 'vue'
import { applicationsService } from '@/lib/applicationsService'

const applications = ref([])
const loading = ref(true)
const expandedId = ref(null)

onMounted(async () => {
  const data = await applicationsService.getAll()
  if (data) applications.value = data
  loading.value = false
})

function toggleExpand(id) {
  expandedId.value = expandedId.value === id ? null : id
}

async function changeStatus(app, status) {
  const updated = await applicationsService.updateStatus(app.id, status)
  if (updated) {
    app.status = status
  }
}

async function deleteApplication(id) {
  if (!confirm('Удалить заявку?')) return
  const ok = await applicationsService.remove(id)
  if (ok) {
    applications.value = applications.value.filter(a => a.id !== id)
  }
}

function statusLabel(status) {
  const map = { new: 'Новая', in_progress: 'В работе', done: 'Готово' }
  return map[status] || status
}

function statusClass(status) {
  return status || 'new'
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Заявки</h1>
    </div>

    <div v-if="loading" class="loading">Загрузка...</div>
    <div v-else-if="applications.length === 0" class="empty">Нет заявок</div>
    <div v-else class="applications-list">
      <div v-for="app in applications" :key="app.id" class="application-card">
        <div class="app-header" @click="toggleExpand(app.id)">
          <div class="app-info">
            <span class="app-name">{{ app.name }}</span>
            <span :class="['badge', statusClass(app.status)]">{{ statusLabel(app.status) }}</span>
          </div>
          <div class="app-meta">
            <span class="app-date">{{ new Date(app.created_at).toLocaleDateString() }}</span>
            <span class="expand-icon">{{ expandedId === app.id ? '▼' : '▶' }}</span>
          </div>
        </div>
        <div v-if="expandedId === app.id" class="app-body">
          <div class="app-details">
            <div v-if="app.email" class="detail"><strong>Email:</strong> {{ app.email }}</div>
            <div v-if="app.phone" class="detail"><strong>Телефон:</strong> {{ app.phone }}</div>
            <div v-if="app.company" class="detail"><strong>Компания:</strong> {{ app.company }}</div>
            <div v-if="app.message" class="detail"><strong>Сообщение:</strong> {{ app.message }}</div>
            <div v-if="app.services?.length" class="detail">
              <strong>Услуги:</strong> {{ app.services.join(', ') }}
            </div>
            <div v-if="app.task_details" class="detail"><strong>Задача:</strong> {{ app.task_details }}</div>
            <div v-if="app.timeframe" class="detail"><strong>Сроки:</strong> {{ app.timeframe }}</div>
            <div v-if="app.budget" class="detail"><strong>Бюджет:</strong> {{ app.budget }}</div>
          </div>
          <div class="app-actions">
            <select :value="app.status" @change="e => changeStatus(app, e.target.value)" class="status-select">
              <option value="new">Новая</option>
              <option value="in_progress">В работе</option>
              <option value="done">Готово</option>
            </select>
            <button class="btn btn-danger" @click="deleteApplication(app.id)">Удалить</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 800px; }
.page-header { margin-bottom: 24px; }
.page-title { font-size: 28px; font-family: 'Space Grotesk', sans-serif; color: #004524; }
.loading, .empty { text-align: center; padding: 48px; color: #999; font-family: 'Roboto Mono', monospace; background: white; border-radius: 16px; }
.applications-list { display: flex; flex-direction: column; gap: 12px; }
.application-card { background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; }
.app-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; cursor: pointer; transition: background 0.2s; }
.app-header:hover { background: #fafafa; }
.app-info { display: flex; align-items: center; gap: 12px; }
.app-name { font-size: 15px; font-family: 'Roboto Mono', monospace; font-weight: 500; color: #333; }
.app-meta { display: flex; align-items: center; gap: 12px; }
.app-date { font-size: 13px; font-family: 'Roboto Mono', monospace; color: #999; }
.expand-icon { font-size: 12px; color: #999; }
.badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-family: 'Roboto Mono', monospace; }
.badge.new { background: #E3F2FD; color: #1565C0; }
.badge.in_progress { background: #FFF3E0; color: #E65100; }
.badge.done { background: #E8F5E9; color: #2E7D32; }
.app-body { padding: 0 20px 16px; border-top: 1px solid #f5f5f5; padding-top: 16px; }
.app-details { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
.detail { font-size: 14px; font-family: 'Roboto Mono', monospace; color: #555; line-height: 1.6; }
.detail strong { color: #333; }
.app-actions { display: flex; gap: 12px; align-items: center; }
.status-select { padding: 8px 12px; border: 1px solid #ddd; border-radius: 10px; font-size: 13px; font-family: 'Roboto Mono', monospace; outline: none; cursor: pointer; }
.status-select:focus { border-color: #44944A; }
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-family: 'Roboto Mono', monospace; border: none; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-danger { background: #fde8e8; color: #c0392b; }
.btn-danger:hover { background: #f8d0d0; }
</style>
