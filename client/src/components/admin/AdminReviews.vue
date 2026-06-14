<script setup>
import { ref, onMounted } from 'vue'
import { reviewsService } from '@/lib/reviewsService'

const reviews = ref([])
const loading = ref(true)

onMounted(async () => {
  const data = await reviewsService.getAll()
  if (data) reviews.value = data
  loading.value = false
})

async function deleteReview(id) {
  if (!confirm('Удалить отзыв?')) return
  const ok = await reviewsService.remove(id)
  if (ok) {
    reviews.value = reviews.value.filter(r => r.id !== id)
  }
}
</script>

<template>
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Отзывы</h1>
      <router-link to="/admin/reviews/new" class="btn btn-primary">+ Новый отзыв</router-link>
    </div>

    <div v-if="loading" class="loading">Загрузка...</div>
    <div v-else-if="reviews.length === 0" class="empty">Нет отзывов</div>
    <table v-else class="table">
      <thead>
        <tr>
          <th>Имя</th>
          <th>Текст</th>
          <th>Дата</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="r in reviews" :key="r.id">
          <td class="cell-name">{{ r.name }}</td>
          <td class="cell-text">{{ r.text.slice(0, 80) }}{{ r.text.length > 80 ? '...' : '' }}</td>
          <td class="cell-date">{{ new Date(r.created_at).toLocaleDateString() }}</td>
          <td class="cell-actions">
            <router-link :to="`/admin/reviews/${r.id}/edit`" class="btn btn-sm">Ред.</router-link>
            <button class="btn btn-sm btn-danger" @click="deleteReview(r.id)">Уд.</button>
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
.cell-name { font-weight: 500; white-space: nowrap; }
.cell-text { color: #666; max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.cell-date { color: #999; font-size: 13px; white-space: nowrap; }
.cell-actions { display: flex; gap: 8px; justify-content: flex-end; }
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-family: 'Roboto Mono', monospace; border: none; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-primary { background: #44944A; color: white; padding: 10px 20px; font-size: 14px; }
.btn-primary:hover { background: #3a7d3d; }
.btn-sm { padding: 6px 12px; font-size: 12px; background: #f0f0f0; color: #333; }
.btn-sm:hover { background: #e0e0e0; }
.btn-danger { background: #fde8e8; color: #c0392b; }
.btn-danger:hover { background: #f8d0d0; }
.loading, .empty { text-align: center; padding: 48px; color: #999; font-family: 'Roboto Mono', monospace; background: white; border-radius: 16px; }
</style>
