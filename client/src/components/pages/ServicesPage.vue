<script setup>
import { ref, computed, onMounted } from 'vue'
import { servicesService, resolveServiceIcon } from '@/lib/servicesService'
import servicesBg from '@/assets/images/services.webp?url';

const services = ref([])
const detailsMap = ref({})
const selectedTag = ref(null)
const selectedCategory = ref('')
const isModalOpen = ref(false)
const loading = ref(true)

onMounted(async () => {
  const [servicesData, detailsData] = await Promise.all([
    servicesService.getAll(),
    servicesService.getAllDetails()
  ])

  if (servicesData) {
    services.value = servicesData
  }

  if (detailsData) {
    detailsMap.value = {}
    detailsData.forEach(d => {
      detailsMap.value[d.sub_item] = d.description
    })
  }

  loading.value = false
})

const openTagModal = (tag, category) => {
  selectedCategory.value = category
  selectedTag.value = tag
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}
</script>


<template>
  <div class="services-page">
    <!-- Hero Section -->
    <section class="hero-section" :style="{ backgroundImage: `url(${servicesBg})` }">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ services</span>
          </div>
          <h1 class="hero-title">
            Услуги, собранные в одну систему роста
          </h1>

          <!-- CTA Button -->
          <router-link 
            to="/application"
            class="cta-button"
          >
            Оставить заявку
          </router-link>
        </div>

      </div>
    </section>

    <!-- Services Grid -->
    <section class="services-section">
      <div v-if="loading" class="loading">Загрузка...</div>
      <div v-else class="services-grid">
        <div 
          v-for="service in services" 
          :key="service.id"
          class="service-card"
        >
          <div class="service-content">
            <!-- Left: Icon & Content -->
            <div class="service-main">
              <!-- Icon -->
              <div class="service-icon">
                <img :src="resolveServiceIcon(service.icon)" :alt="service.title" loading="lazy" />
              </div>

              <!-- Title -->
              <h3 class="service-title">{{ service.title }}</h3>

              <!-- Description -->
              <p class="service-description">{{ service.description }}</p>

              <!-- Sub Items Grid -->
              <div class="sub-items-grid">
                <div 
                  v-for="(subItem, subIndex) in service.sub_items" 
                  :key="subIndex"
                  class="sub-item"
                  @click="openTagModal(subItem, service.category)"
                >
                  <span class="sub-item-text">{{ subItem }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Drawer -->
    <Teleport to="body">
      <Transition name="drawer-overlay">
        <div v-if="isModalOpen" class="drawer-overlay" @click="closeModal">
          <Transition name="drawer-panel">
            <div v-if="isModalOpen" class="drawer-panel" @click.stop>
              <button class="drawer-close" @click="closeModal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
              <div class="drawer-category">{{ selectedCategory }}</div>
              <h3 class="drawer-title">{{ selectedTag }}</h3>
              <p class="drawer-description">{{ detailsMap[selectedTag] }}</p>
              <router-link to="/application" class="drawer-cta" @click="closeModal">
                Обсудить проект
              </router-link>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<style scoped>
.services-page {
  flex: 1;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px 80px;
  background-size: cover;
  background-position: center top;
  background-repeat: no-repeat;
  min-height: 800px;
  border-radius: 40px;
  animation: heroFadeIn 0.8s ease-out;
}

@media (min-width: 768px) {
  .hero-section {
    min-height: 900px;
  }
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
  color: #44944A;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.hero-title {
  color: #004524;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  text-transform: uppercase;
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
  height: 65px;
  padding: 0 40px;
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
  margin-top: 40px;
  display: block;
}

.services-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.services-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 1280px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.service-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 32px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
  transition: all 0.3s;
  cursor: pointer;
}

.service-card:hover {
  border-color: rgba(68, 148, 74, 0.5);
}

.service-content {
  display: flex;
  gap: 32px;
}

.service-main {
  flex: 1;
}

.service-icon {
  width: 64px;
  height: 64px;
  border-radius: 20px;
  background-color: rgba(0.62, 254.99, 101.98, 0.10);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  transition: transform 0.3s;
}

.service-card:hover .service-icon {
  transform: scale(1.1);
}

.service-icon img {
  width: 32px;
  height: 32px;
}

.service-title {
  color: white;
  font-size: 34px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 16px;
}

.service-description {
  color: rgba(255, 255, 255, 0.72);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2;
  margin-bottom: 24px;
}

.sub-items-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.sub-item {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 20px;
  padding: 20px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  transition: background-color 0.3s;
  cursor: pointer;
}

.sub-item:hover {
  background-color: rgba(68, 148, 74, 0.3);
  border-color: rgba(68, 148, 74, 0.5);
}

.sub-item-text {
  color: white;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
}

.drawer-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  display: flex;
  justify-content: flex-end;
}

.drawer-panel {
  width: 100%;
  max-width: 500px;
  height: 100%;
  background-color: #004524;
  padding: 40px;
  position: relative;
  border-left: 1px solid rgba(68, 148, 74, 0.3);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.drawer-close {
  position: absolute;
  top: 20px;
  right: 20px;
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.3s;
  padding: 8px;
}

.drawer-close:hover {
  opacity: 1;
}

.drawer-category {
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  margin-top: 60px;
  opacity: 0.6;
}

.drawer-title {
  color: white;
  font-size: 32px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 24px;
  margin-top: 12px;
}

.drawer-description {
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.8;
  flex: 1;
}

.drawer-cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 60px;
  background-color: #44944A;
  border-radius: 16px;
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
  margin-top: 32px;
}

.drawer-cta:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

/* Animations */
.drawer-overlay-enter-active,
.drawer-overlay-leave-active {
  transition: opacity 0.3s ease;
}

.drawer-overlay-enter-from,
.drawer-overlay-leave-to {
  opacity: 0;
}

.drawer-panel-enter-active,
.drawer-panel-leave-active {
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.drawer-panel-enter-from,
.drawer-panel-leave-to {
  transform: translateX(100%);
}

.loading {
  text-align: center;
  padding: 48px;
  color: #004524;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
}

@media (max-width: 768px) {
  .drawer-panel {
    max-width: 100%;
    padding: 24px;
  }

  .drawer-title {
    font-size: 24px;
    margin-top: 32px;
  }

  .drawer-description {
    font-size: 16px;
  }
}
</style>