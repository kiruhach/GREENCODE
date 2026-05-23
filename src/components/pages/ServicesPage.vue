<script setup>
import { ref } from 'vue'
import createSiteIcon from '@/assets/icons/create_site.svg?url';
import seoUpIcon from '@/assets/icons/seo_up.svg?url';
import designIcon from '@/assets/icons/design.svg?url';
import brandingIcon from '@/assets/icons/branding.svg?url';
import contentMarketingIcon from '@/assets/icons/content_marketing.svg?url';
import webAnalyticsIcon from '@/assets/icons/web_analytics.svg?url';
import mozaikaImage from '@/assets/images/mozaika.webp?url';

const selectedTag = ref(null)
const isModalOpen = ref(false)

const subItemDescriptions = {
  'Корпоративные сайты': 'Полнофункциональные сайты компаний с презентацией услуг, команды, контактов и экспертизы. Включают смысловые страницы, каталог услуг, форму заявки и интеграции.',
  'Интернет-магазины': 'Полноценные магазины с каталогом товаров, корзиной, оформлением заказов, личным кабинетом и интеграциями с платёжными системами и 1С.',
  'Landing Page': 'Посадочные страницы для конкретных целей: продажа товара, сбор заявок, регистрация на мероприятие. С фокусом на конверсию.',
  'Техническая оптимизация': 'Ускорение загрузки, оптимизация кода, настройка кэширования, исправление ошибок и улучшение технических показателей.',
  'SEO-аудит': 'Комплексный анализ сайта: техническое состояние, контент, структура, конкуренты. Выявляем проблемы и возможности роста.',
  'Внутренняя оптимизация': 'Работа с контентом, структурой, мета-тегами, внутренними ссылками. Настройка ЧПУ, карт сайта, Robots.txt.',
  'Внешняя оптимизация': 'Наращивание качественной ссылочной массы, работа с репутацией, размещение на тематических площадках.',
  'Генеративная оптимизация': 'Подготовка сайта к появлению в AI-поиске и голосовых системах. Структурированные данные и оптимизация под LLM.',
  'UI/UX дизайн': 'Проектирование визуально привлекательных и удобных интерфейсов с учётом поведения пользователей и целей бизнеса.',
  'Прототипирование': 'Создание макетов страниц и интерактивных прототипов для согласования структуры до начала дизайна.',
  'Дизайн-системы': 'Разработка единой системы компонентов, стилей и правил для масштабирования дизайна на большой проект.',
  'Адаптивные интерфейсы': 'Верстка корректно работающая на всех устройствах: десктоп, планшет, мобильный телефон.',
  'Смысловая платформа': 'Разработка основных смыслов бренда: миссия, ценности, позиционирование, УТП.',
  'Визуальный код': 'Создание цветовой палитры, типографики, иконок и графических элементов бренда.',
  'Голос бренда': 'Определение тона и стиля коммуникации бренда: как говорить с аудиторией.',
  'Правила работы со стилем': 'Брендбук и гайдлайны по использованию фирменного стиля во всех каналах.',
  'Контент-стратегия': 'Планирование контента для достижения бизнес-целей: воронка, типы контента, каналы.',
  'SEO-статьи': 'Написание экспертных оптимизированных статей для привлечения органического трафика.',
  'Тексты для сайта': 'Создание продающих текстов для главной, страниц услуг, карточек товаров.',
  'Контент-планы': 'Редакционный календарь с планированием публикаций по сезонам и целям.',
  'Настройка целей и событий': 'Подключение систем аналитики для отслеживания действий пользователей.',
  'Панели показателей': 'Визуализация ключевых метрик в удобных дашбордах для принятия решений.',
  'Отчётность': 'Регулярные отчёты о результатах продвижения и рекомендации по улучшению.',
  'Метрики улучшения результатов': 'Анализ данных и поиск точек роста для увеличения эффективности.'
}

const services = [
  {
    iconSrc: createSiteIcon,
    title: 'Разработка сайтов',
    description: 'Корпоративные сайты, интернет-магазины и Landing Page, где производительность, структура и визуальный стиль работают на результат.',
    subItems: ['Корпоративные сайты', 'Интернет-магазины', 'Landing Page', 'Техническая оптимизация'],
    category: 'Разработка сайтов'
  },
  {
    iconSrc: seoUpIcon,
    title: 'SEO-продвижение',
    description: 'Делаем SEO частью продукта с первого дня: от аудита до внутренней и внешней оптимизации, включая генеративный поиск.',
    subItems: ['SEO-аудит', 'Внутренняя оптимизация', 'Внешняя оптимизация', 'Генеративная оптимизация'],
    category: 'SEO-продвижение'
  },
  {
    iconSrc: designIcon,
    title: 'Веб-дизайн',
    description: 'Проектируем интерфейсы с фокусом на пользовательский сценарий, визуальный ритм и конверсию.',
    subItems: ['UI/UX дизайн', 'Прототипирование', 'Дизайн-системы', 'Адаптивные интерфейсы'],
    category: 'Веб-дизайн'
  },
  {
    iconSrc: brandingIcon,
    title: 'Брендинг',
    description: 'Создаём айдентику, которая делает бизнес узнаваемым и помогает держать единый тон во всех цифровых точках.',
    subItems: ['Смысловая платформа', 'Визуальный код', 'Голос бренда', 'Правила работы со стилем'],
    category: 'Брендинг'
  },
  {
    iconSrc: contentMarketingIcon,
    title: 'Контент-маркетинг',
    description: 'Помогаем бренду говорить убедительно: через контент-стратегию, SEO-материалы и тексты для воронки продаж.',
    subItems: ['Контент-стратегия', 'SEO-статьи', 'Тексты для сайта', 'Контент-планы'],
    category: 'Контент-маркетинг'
  },
  {
    iconSrc: webAnalyticsIcon,
    title: 'Веб-аналитика',
    description: 'Настраиваем аналитическую основу: дашборды, события, отчёты и контроль за воронкой.',
    subItems: ['Настройка целей и событий', 'Панели показателей', 'Отчётность', 'Метрики улучшения результатов'],
    category: 'Веб-аналитика'
  }
]

const selectedCategory = ref('')

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
    <section class="hero-section">
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

        <!-- Right Column - Hero Image Placeholder -->
        <div class="hero-right">
          <img :src="mozaikaImage" alt="Mozaika" class="hero-image-placeholder" />
        </div>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="services-section">
      <div class="services-grid">
        <div 
          v-for="(service, index) in services" 
          :key="index"
          class="service-card"
        >
          <div class="service-content">
            <!-- Left: Icon & Content -->
            <div class="service-main">
              <!-- Icon -->
              <div class="service-icon">
                <img :src="service.iconSrc" :alt="service.title" />
              </div>

              <!-- Title -->
              <h3 class="service-title">{{ service.title }}</h3>

              <!-- Description -->
              <p class="service-description">{{ service.description }}</p>

              <!-- Sub Items Grid -->
              <div class="sub-items-grid">
                <div 
                  v-for="(subItem, subIndex) in service.subItems" 
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
              <p class="drawer-description">{{ subItemDescriptions[selectedTag] }}</p>
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
  min-height: 100vh;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px 80px;
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