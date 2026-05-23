<script setup>
import { ref, computed, onMounted } from 'vue';
import { supabase } from '@/lib/supabase';
import { resolveCaseImage } from '@/lib/casesService';
import graphicImage from '@/assets/images/graphic.webp?url';

const filters = [
  { id: 'all', label: 'Все кейсы' },
  { id: 'development', label: 'Разработка сайтов' },
  { id: 'seo', label: 'SEO-продвижение' },
  { id: 'design', label: 'Веб-дизайн и UI/UX' },
  { id: 'content', label: 'Контент-маркетинг' },
  { id: 'analytics', label: 'Веб-аналитика' }
]

const activeFilter = ref('all')
const cases = ref([])
const loading = ref(true)

onMounted(async () => {
  await fetchCases()
})

async function fetchCases() {
  loading.value = true
  const { data, error } = await supabase
    .from('cases')
    .select('*')
    .order('created_at', { ascending: false })

  if (!error && data) {
    cases.value = data
  }
  loading.value = false
}

const filteredCases = computed(() => {
  if (activeFilter.value === 'all') {
    return cases.value
  }
  return cases.value.filter(c => c.category === activeFilter.value)
})
</script>

<template>
  <div class="cases-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ cases</span>
          </div>
          <h1 class="hero-title">
            Кейсы, где рост видно в цифрах
          </h1>
          <p class="hero-description"></p>
          <!-- CTA Button -->
          <router-link 
            to="/application"
            class="cta-button"
          >
            Оставить заявку
          </router-link>
        </div>

        <!-- Right Column - Hero Image -->
        <div class="hero-right">
          <img :src="graphicImage" alt="Graphic" class="hero-image-placeholder" />
        </div>
      </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
      <div class="filters-container">
        <button 
          v-for="filter in filters" 
          :key="filter.id"
          :class="['filter-button', { active: activeFilter === filter.id }]"
          @click="activeFilter = filter.id"
        >
          {{ filter.label }}
        </button>
      </div>
    </section>

    <!-- Cases Grid -->
    <section class="cases-section">
      <div v-if="loading" class="loading">Загрузка...</div>
      <div v-else-if="filteredCases.length === 0" class="empty">
        Кейсы не найдены
      </div>
      <div v-else class="cases-grid">
        <router-link 
          v-for="(caseItem, index) in filteredCases" 
          :key="caseItem.id"
          :to="`/cases/${caseItem.id}`"
          class="case-card"
        >
          <!-- Image -->
          <img 
            :src="resolveCaseImage(caseItem.image)"
            :alt="caseItem.title" 
            class="case-image"
            width="400"
            height="320"
            loading="lazy"
          />

          <!-- Content -->
          <div class="case-content">
            <!-- Title -->
            <h3 class="case-title">{{ caseItem.title }}</h3>

            <!-- Description -->
            <p class="case-description">{{ caseItem.description }}</p>
            <div class="case-tags">
              <span v-for="(tag, tagIndex) in caseItem.tags" :key="tagIndex" class="case-tag">{{ tag }}</span>
            </div>
          </div>
        </router-link>
      </div>
    </section>
  </div>
</template>

<style scoped>
.cases-page {
  min-height: 100vh;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px 48px;
}

.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 32px;
}

@media (min-width: 1280px) {
  .hero-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.section-label {
  margin-bottom: 32px;
}

.section-label span {
  color: #004524;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.hero-title {
  color: #004524;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 72px;
  }
}

@media (min-width: 1024px) {
  .hero-title {
    font-size: 100px;
  }
}

.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 261px;
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

.hero-right {
  display: none;
}

@media (min-width: 1280px) {
  .hero-right {
    display: flex;
    justify-content: flex-end;
  }
}

.hero-image-placeholder {
  width: 800px;
  height: 462px;
  border-radius: 40px;
  object-fit: cover;
  margin-left: auto;
  display: block;
}

.filters-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 0 24px 40px;
}

.filters-container {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.filter-button {
  padding: 14px 24px;
  background-color: transparent;
  border: 1px solid rgba(68, 148, 74, 0.3);
  border-radius: 12px;
  color: rgba(255, 255, 255, 0.7);
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  cursor: pointer;
  transition: all 0.3s;
}

.filter-button:hover {
  border-color: rgba(68, 148, 74, 0.6);
  color: white;
}

.filter-button.active {
  background-color: #44944A;
  border-color: #44944A;
  color: white;
}

.cases-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.cases-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 768px) {
  .cases-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1280px) {
  .cases-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.case-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 32px;
  overflow: hidden;
  border: 1px solid rgba(68, 148, 74, 0.2);
  transition: border-color 0.3s, transform 0.3s;
  cursor: pointer;
  will-change: transform;
}

.case-card:hover {
  border-color: rgba(68, 148, 74, 0.5);
  transform: translateY(-4px);
}

.case-image {
  width: calc(100% - 48px);
  height: 320px;
  object-fit: cover;
  margin: 24px 24px 0 24px;
  border-radius: 28px 28px 0 0;
}

.case-card:hover .case-image {
  opacity: 0.9;
}

.case-content {
  padding: 0 32px 32px;
}

.case-title {
  color: white;
  font-size: 32px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 16px;
  line-height: 1.25;
}

@media (min-width: 768px) {
  .case-title {
    font-size: 38px;
  }
}

.case-description {
  color: rgba(255, 255, 255, 0.7);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2;
  margin-bottom: 16px;
}

.case-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.case-tag {
  background-color: rgba(0, 255, 102, 0.1);
  border: 1px solid rgba(68, 148, 74, 0.3);
  border-radius: 20px;
  padding: 6px 14px;
  color: rgba(255, 255, 255, 0.8);
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
}

.loading,
.empty {
  text-align: center;
  padding: 48px;
  color: #004524;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
}
</style>