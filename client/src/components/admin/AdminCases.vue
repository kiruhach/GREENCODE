<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { casesService } from '@/lib/casesService'

const router = useRouter()
const cases = ref([])
const loading = ref(true)

onMounted(async () => {
  const data = await casesService.getAll()
  if (data) cases.value = data
  loading.value = false
})

async function deleteCase(id) {
  if (!confirm('Удалить кейс?')) return
  const ok = await casesService.remove(id)
  if (ok) {
    cases.value = cases.value.filter(c => c.id !== id)
  }
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Кейсы</h1>
      <router-link to="/admin/cases/new" class="btn btn-primary">+ Новый кейс</router-link>
    </div>

    <div v-if="loading" class="loading">Загрузка...</div>
    <div v-else-if="cases.length === 0" class="empty">Нет кейсов</div>
    <table v-else class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>Категория</th>
          <th>Дата</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="c in cases" :key="c.id">
          <td class="cell-title">{{ c.title }}</td>
          <td><span class="badge">{{ c.category }}</span></td>
          <td class="cell-date">{{ new Date(c.created_at).toLocaleDateString() }}</td>
          <td class="cell-actions">
            <router-link :to="`/admin/cases/${c.id}/edit`" class="btn btn-sm">Ред.</router-link>
            <button class="btn btn-sm btn-danger" @click="deleteCase(c.id)">Уд.</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.page { max-width: 1000px; }
.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
.page-title { font-size: 28px; font-family: 'Space Grotesk', sans-serif; color: #004524; }
.table { width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-collapse: collapse; }
.table th { text-align: left; padding: 14px 20px; font-size: 12px; font-family: 'Roboto Mono', monospace; color: #999; text-transform: uppercase; letter-spacing: 1px; background: #fafafa; border-bottom: 1px solid #eee; }
.table td { padding: 14px 20px; font-size: 14px; font-family: 'Roboto Mono', monospace; color: #333; border-bottom: 1px solid #f5f5f5; }
.cell-title { font-weight: 500; }
.cell-date { color: #999; font-size: 13px; }
.cell-actions { display: flex; gap: 8px; justify-content: flex-end; }
.badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; background: #E8F5E9; color: #2E7D32; }
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-family: 'Roboto Mono', monospace; border: none; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-primary { background: #44944A; color: white; padding: 10px 20px; font-size: 14px; }
.btn-primary:hover { background: #3a7d3d; }
.btn-sm { padding: 6px 12px; font-size: 12px; background: #f0f0f0; color: #333; }
.btn-sm:hover { background: #e0e0e0; }
.btn-danger { background: #fde8e8; color: #c0392b; }
.btn-danger:hover { background: #f8d0d0; }
.loading, .empty { text-align: center; padding: 48px; color: #999; font-family: 'Roboto Mono', monospace; background: white; border-radius: 16px; }
</style>
