<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { supabase } from '@/lib/supabase'
import { resolveCaseImage } from '@/lib/casesService'

const route = useRoute()
const currentCase = ref(null)
const loading = ref(true)

onMounted(async () => {
  await fetchCase()
})

async function fetchCase() {
  loading.value = true
  const { data, error } = await supabase
    .from('cases')
    .select('*')
    .eq('id', route.params.id)
    .single()

  if (!error && data) {
    currentCase.value = data
  }
  loading.value = false
}

const categoryLabel = computed(() => {
  const labels = {
    development: 'Разработка',
    seo: 'SEO',
    design: 'Дизайн',
    content: 'Контент',
    analytics: 'Аналитика'
  }
  return currentCase.value ? labels[currentCase.value.category] : ''
})
</script>

<template>
  <div class="case-detail-page" v-if="currentCase">
    <!-- Hero Section -->
    <section class="hero-section">
      <router-link to="/cases" class="back-link">
        ← К списку кейсов
      </router-link>

      <div class="hero-content">
        <div class="case-category">{{ categoryLabel }}</div>
        <h1 class="case-title">{{ currentCase.title }}</h1>
        <p class="case-description">{{ currentCase.description }}</p>

        <div class="result-badge">
          <span class="result-label">Результат:</span>
          <span class="result-value">{{ currentCase.result }}</span>
        </div>
      </div>

      <img v-fade-in :src="resolveCaseImage(currentCase.image)" :alt="currentCase.title" class="case-detail-image" width="800" height="500" />
    </section>

    <!-- Tags -->
    <section class="tags-section">
      <div class="tags-grid">
        <div v-for="(tag, index) in currentCase.tags" :key="index" class="tag">
          {{ tag }}
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="content-section">
      <div class="content-block">
        <h2 class="block-title">Задача</h2>
        <p class="block-text">{{ currentCase.task }}</p>
      </div>

      <div class="content-block">
        <h2 class="block-title">Решение</h2>
        <p class="block-text">{{ currentCase.solution }}</p>
      </div>

      <div class="content-block results-block">
        <h2 class="block-title">Результаты</h2>
        <ul class="results-list">
          <li v-for="(result, index) in currentCase.results" :key="index">
            {{ result }}
          </li>
        </ul>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
      <h2 class="cta-title">Хотите похожий результат?</h2>
      <router-link to="/application" class="cta-button">
        Обсудить проект
      </router-link>
    </section>
  </div>

  <div v-else-if="loading" class="loading">
    Загрузка...
  </div>

  <div v-else class="not-found">
    <h1>Кейс не найден</h1>
    <router-link to="/cases">Вернуться к кейсам</router-link>
  </div>
</template>

<style scoped>
.case-detail-page {
  min-height: 100vh;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px;
  display: grid;
  grid-template-columns: 1fr;
  gap: 32px;
}

@media (min-width: 1024px) {
  .hero-section {
    grid-template-columns: 1fr 1fr;
    align-items: center;
  }
}

.back-link {
  color: #004524;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  grid-column: 1 / -1;
}

.back-link:hover {
  text-decoration: underline;
}

.case-category {
  color: #44944A;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 16px;
}

.case-title {
  color: #004524;
  font-size: 42px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.2;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .case-title {
    font-size: 56px;
  }
}

.case-description {
  color: #004524;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.8;
  margin-bottom: 32px;
}

.result-badge {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  background-color: #004524;
  padding: 16px 24px;
  border-radius: 16px;
}

.result-label {
  color: rgba(255, 255, 255, 0.6);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.result-value {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
}

.case-detail-image {
  width: 100%;
  max-width: 800px;
  height: 500px;
  object-fit: cover;
  border-radius: 32px;
}

.tags-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 0 24px 40px;
}

.tags-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.tag {
  background-color: rgba(0, 69, 36, 0.1);
  border: 1px solid rgba(0, 69, 36, 0.2);
  padding: 12px 20px;
  border-radius: 12px;
  color: #004524;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.content-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.content-block {
  background-color: #004524;
  border-radius: 32px;
  padding: 40px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.results-block {
  background: linear-gradient(135deg, #004524 0%, #006630 100%);
}

.block-title {
  color: white;
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  margin-bottom: 20px;
}

.block-text {
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.8;
}

.results-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.results-list li {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  padding: 16px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  padding-left: 32px;
  position: relative;
}

.results-list li::before {
  content: '→';
  position: absolute;
  left: 0;
  color: #44944A;
}

.results-list li:last-child {
  border-bottom: none;
}

.cta-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 80px 24px;
  text-align: center;
}

.cta-title {
  color: #004524;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  margin-bottom: 32px;
}

.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 280px;
  height: 65px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 20px;
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
}

.cta-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.loading {
  text-align: center;
  padding: 100px 24px;
  color: #004524;
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
}

.not-found {
  text-align: center;
  padding: 100px 24px;
}

.not-found h1 {
  color: #004524;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 24px;
}

.not-found a {
  color: #44944A;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
}
</style>