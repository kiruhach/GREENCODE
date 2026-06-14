<script setup>
import { ref, onMounted } from 'vue'
import { casesService } from '@/lib/casesService'
import { servicesService } from '@/lib/servicesService'
import { reviewsService } from '@/lib/reviewsService'
import { applicationsService } from '@/lib/applicationsService'

const stats = ref([])
const recentApplications = ref([])

onMounted(async () => {
  const [cases, services, reviews, applications] = await Promise.all([
    casesService.getAll(),
    servicesService.getAll(),
    reviewsService.getAll(),
    applicationsService.getAll()
  ])

  stats.value = [
    { label: 'Кейсы', count: cases?.length ?? 0, color: '#44944A' },
    { label: 'Услуги', count: services?.length ?? 0, color: '#004524' },
    { label: 'Отзывы', count: reviews?.length ?? 0, color: '#A8E4A0' },
    { label: 'Заявки', count: applications?.length ?? 0, color: '#92FFAD' }
  ]

  if (applications) {
    recentApplications.value = applications.slice(0, 5)
  }
})

function statusLabel(status) {
  const map = { new: 'Новая', in_progress: 'В работе', done: 'Готово' }
  return map[status] || status
}

function statusClass(status) {
  return status || 'new'
}
</script>

<template>
  <div class="dashboard">
    <h1 class="page-title">Дашборд</h1>

    <div class="stats-grid">
      <div v-for="stat in stats" :key="stat.label" class="stat-card">
        <div class="stat-count" :style="{ color: stat.color }">{{ stat.count }}</div>
        <div class="stat-label">{{ stat.label }}</div>
      </div>
    </div>

    <section class="recent-section">
      <h2 class="section-title">Последние заявки</h2>
      <div v-if="recentApplications.length === 0" class="empty">Нет заявок</div>
      <table v-else class="table">
        <thead>
          <tr>
            <th>Дата</th>
            <th>Имя</th>
            <th>Статус</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="app in recentApplications" :key="app.id">
            <td>{{ new Date(app.created_at).toLocaleDateString() }}</td>
            <td>{{ app.name }}</td>
            <td><span :class="['badge', statusClass(app.status)]">{{ statusLabel(app.status) }}</span></td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<style scoped>
.dashboard {
  max-width: 1000px;
}

.page-title {
  font-size: 28px;
  font-family: 'Space Grotesk', sans-serif;
  color: #004524;
  margin-bottom: 32px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 40px;
}

.stat-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.stat-count {
  font-size: 36px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 700;
}

.stat-label {
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  color: #666;
  margin-top: 8px;
}

.section-title {
  font-size: 20px;
  font-family: 'Space Grotesk', sans-serif;
  color: #004524;
  margin-bottom: 16px;
}

.table {
  width: 100%;
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  border-collapse: collapse;
}

.table th {
  text-align: left;
  padding: 14px 20px;
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
  color: #999;
  text-transform: uppercase;
  letter-spacing: 1px;
  background: #fafafa;
  border-bottom: 1px solid #eee;
}

.table td {
  padding: 14px 20px;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  color: #333;
  border-bottom: 1px solid #f5f5f5;
}

.badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
}

.badge.new {
  background: #E3F2FD;
  color: #1565C0;
}

.badge.in_progress {
  background: #FFF3E0;
  color: #E65100;
}

.badge.done {
  background: #E8F5E9;
  color: #2E7D32;
}

.empty {
  text-align: center;
  padding: 32px;
  color: #999;
  font-family: 'Roboto Mono', monospace;
  background: white;
  border-radius: 16px;
}
</style>
