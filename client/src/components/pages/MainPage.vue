<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { applicationsService } from '@/lib/applicationsService'
import { casesService, resolveCaseImage } from '@/lib/casesService'
import { reviewsService } from '@/lib/reviewsService'
import heroBg from '@/assets/images/hero.webp?url';
import createSiteIcon from '@/assets/icons/create_site.svg?url';
import seoUpIcon from '@/assets/icons/seo_up.svg?url';
import designIcon from '@/assets/icons/design.svg?url';
import brandingIcon from '@/assets/icons/branding.svg?url';
import contentMarketingIcon from '@/assets/icons/content_marketing.svg?url';
import webAnalyticsIcon from '@/assets/icons/web_analytics.svg?url';
import greencodeVideo from '@/assets/videos/greencode_video.webm?url';

onMounted(async () => {
  const script = document.createElement('script')
  script.type = 'module'
  script.src = 'https://unpkg.com/@splinetool/viewer@1.12.94/build/spline-viewer.js'
  document.head.appendChild(script)

  const interval = setInterval(() => {
    const viewer = document.querySelector('spline-viewer')
    if (viewer && viewer.shadowRoot) {
      const logo = viewer.shadowRoot.querySelector('#logo')
      if (logo) {
        logo.remove()
        clearInterval(interval)
      }
    }
  }, 500)

  await Promise.all([fetchCases(), fetchReviews()])
  await nextTick()
  observeCases()
})

let caseObserver = null

function observeCases() {
  if (caseObserver) caseObserver.disconnect()

  caseObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('case-visible')
        caseObserver.unobserve(entry.target)
      }
    })
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' })

  document.querySelectorAll('.case-card').forEach((el) => {
    caseObserver.observe(el)
    el.addEventListener('animationend', () => {
      el.classList.add('case-animated')
    }, { once: true })
  })
}

const cases = ref([])
const loadingCases = ref(true)
const casesError = ref('')

async function fetchCases() {
  loadingCases.value = true
  casesError.value = ''
  try {
    const data = await casesService.getAll()
    if (data) {
      cases.value = data.slice(0, 3)
    }
  } catch {
    casesError.value = 'Не удалось загрузить кейсы'
  }
  loadingCases.value = false
}

const services = [
  {
    iconSrc: createSiteIcon,
    title: 'Разработка сайтов',
    description: 'Корпоративные сайты, интернет-магазины и Landing Page с акцентом на скорость, удобство и конверсию.'
  },
  {
    iconSrc: seoUpIcon,
    title: 'SEO-продвижение',
    description: 'SEO-аудит, внутренняя и внешняя оптимизация, а также генеративная оптимизация под новый поиск.'
  },
  {
    iconSrc: designIcon,
    title: 'Веб-дизайн',
    description: 'UI/UX дизайн и проектирование интерфейсов, которые выглядят дорого и ведут пользователя к действию.'
  },
  {
    iconSrc: brandingIcon,
    title: 'Брендинг',
    description: 'Брендинг и фирменный стиль под ключ, чтобы бизнес запоминали с первого контакта.'
  },
  {
    iconSrc: contentMarketingIcon,
    title: 'Контент-маркетинг',
    description: 'Контент-стратегия, SEO-статьи и тексты, которые усиливают видимость и доверие к бренду.'
  },
  {
    iconSrc: webAnalyticsIcon,
    title: 'Веб-аналитика',
    description: 'Настройка аналитики, дашборды и отчётность, чтобы каждое решение опиралось на цифры.'
  }
]

const email = ref('')
const phone = ref('')

const handleEmailInput = (e) => {
  const latinOnly = e.target.value.replace(/[^a-zA-Z0-9@._-]/g, '')
  email.value = latinOnly
}

const formatPhone = (e) => {
  let value = e.target.value.replace(/\D/g, '')
  if (value.length > 11) {
    value = value.slice(0, 11)
  }
  if (value.length > 0) {
    if (!value.startsWith('7') && !value.startsWith('8')) {
      value = '7' + value
    }
    if (value.startsWith('8')) {
      value = '7' + value.slice(1)
    }
  }
  let formatted = '+7'
  if (value.length > 1) formatted += ' (' + value.slice(1, 4)
  if (value.length > 4) formatted += ') ' + value.slice(4, 7)
  if (value.length > 7) formatted += '-' + value.slice(7, 9)
  if (value.length > 9) formatted += '-' + value.slice(9, 11)
  phone.value = formatted
}

const reviews = ref([])
const loadingReviews = ref(true)
const reviewsError = ref('')

async function fetchReviews() {
  loadingReviews.value = true
  reviewsError.value = ''
  try {
    const data = await reviewsService.getLatest(2)
    if (data) {
      reviews.value = data
    }
  } catch {
    reviewsError.value = 'Не удалось загрузить отзывы'
  }
  loadingReviews.value = false
}

const name = ref('')
const message = ref('')
const loading = ref(false)
const success = ref(false)
const error = ref('')
const fieldErrors = ref({})

function validateForm() {
  const errs = {}
  if (!name.value.trim()) errs.name = 'Укажите ваше имя'
  if (!email.value.trim()) errs.email = 'Укажите email'
  else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) errs.email = 'Некорректный email'
  if (!phone.value.trim()) errs.phone = 'Укажите телефон'
  else if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone.value)) errs.phone = 'Некорректный телефон'
  fieldErrors.value = errs
  return Object.keys(errs).length === 0
}

function fieldClass(field) {
  return { 'form-input--error': fieldErrors.value[field] }
}

async function submitForm() {
  if (!validateForm()) return

  loading.value = true
  error.value = ''
  fieldErrors.value = {}

  try {
    await applicationsService.create({
      name: name.value,
      email: email.value || null,
      phone: phone.value || null,
      message: message.value || null
    })
    loading.value = false
    success.value = true
    name.value = ''
    email.value = ''
    phone.value = ''
    message.value = ''
  } catch {
    loading.value = false
    error.value = 'Ошибка при отправке. Попробуйте ещё раз.'
  }
}
</script>

<template>
  <div class="main-page">
    <!-- Background Spline -->
    <spline-viewer url="https://prod.spline.design/fcVRjDk4PZ0xx9Iw/scene.splinecode"></spline-viewer>

    <!-- Hero Section -->
    <section class="hero-section" :style="{ backgroundImage: `url(${heroBg})` }">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <!-- Badge -->
          <div class="badge">
            <span class="badge-dot"></span>
            <span class="badge-text">digital-агентство</span>
          </div>

          <!-- Title -->
          <h1 class="hero-title">
            GREENCODE
          </h1>

          <!-- Description -->
          <p class="hero-description">
            Пишем чистый код. Растим ваш бизнес.<br>
            Мы не просто делаем сайты — мы строим цифровую основу для роста вашего бизнеса. Каждый проект начинается с погружения в задачу и заканчивается измеримым результатом.<br>
            Берём на себя полный цикл: от стратегии и дизайна до разработки, SEO и аналитики. Вы сосредоточены на бизнесе — мы на цифре.
          </p>

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

    <!-- Services Section -->
    <section class="services-section">
      <div class="section-label">
        <span>/ services</span>
      </div>
      <h2 class="section-title">Услуги</h2>

      <!-- Services Grid -->
      <div class="services-grid">
        <router-link 
          v-for="(service, index) in services" 
          :key="index"
          :to="'/services'"
          class="service-card"
        >
          <!-- Icon -->
          <div class="service-icon">
            <img :src="service.iconSrc" :alt="service.title" loading="lazy" />
          </div>

          <!-- Title -->
          <h3 class="service-title">{{ service.title }}</h3>

          <!-- Description -->
          <p class="service-description">{{ service.description }}</p>

          <!-- Learn More -->
          <div class="service-learn-more">
            <span>Подробнее</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </div>
        </router-link>
      </div>
    </section>

    <!-- Video Section -->
    <section class="video-section">
      <video
        class="greencode-video"
        :src="greencodeVideo"
        autoplay
        muted
        loop
        playsinline
      ></video>
    </section>

    <!-- Cases Section -->
    <section class="cases-section">
      <div class="section-label">
        <span>/ cases</span>
      </div>
      <h2 class="section-title">Кейсы</h2>

      <div v-if="loadingCases" class="spinner-wrapper">
        <div class="spinner"></div>
      </div>
      <div v-else-if="casesError" class="error-block">
        <p>{{ casesError }}</p>
        <button class="retry-btn" @click="fetchCases">Повторить</button>
      </div>
      <template v-else-if="cases.length === 0">
        <div class="empty-block">Кейсы пока не добавлены</div>
      </template>
      <template v-else>
      <!-- Cases Grid -->
      <div class="cases-grid">
        <router-link 
          v-for="(caseItem, index) in cases" 
          :key="index"
          :to="`/cases/${caseItem.id}`"
          class="case-card"
        >
          <!-- Image -->
           <img :src="resolveCaseImage(caseItem.image)" :alt="caseItem.title" class="case-image" loading="lazy" width="400" height="280" />

          <!-- Content -->
          <div class="case-content">
            <h3 class="case-title">{{ caseItem.title }}</h3>
            <p class="case-description">{{ caseItem.description }}</p>
            <div class="case-tags">
              <span v-for="(tag, tagIndex) in caseItem.tags" :key="tagIndex" class="case-tag">{{ tag }}</span>
            </div>
          </div>
        </router-link>
      </div>
      </template>
      <!-- View All Button -->
      <div class="view-all-wrapper">
        <router-link 
          to="/cases"
          class="view-all-button"
        >
          Смотреть все кейсы
        </router-link>
      </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section">
      <div class="section-label">
        <span>/ reviews</span>
      </div>
      <h2 class="section-title">Отзывы клиентов</h2>

      <div v-if="loadingReviews" class="spinner-wrapper">
        <div class="spinner"></div>
      </div>
      <div v-else-if="reviewsError" class="error-block">
        <p>{{ reviewsError }}</p>
        <button class="retry-btn" @click="fetchReviews">Повторить</button>
      </div>
      <div v-else-if="reviews.length === 0" class="empty-block">Отзывов пока нет</div>
      <template v-else>
      <!-- Reviews Grid -->
      <div class="reviews-grid">
        <div 
          v-for="(review, index) in reviews" 
          :key="index"
          class="review-card"
        >
          <!-- Review Text -->
          <p class="review-text">"{{ review.text }}"</p>

          <!-- Author -->
          <div class="review-author">
            <div class="author-avatar">
              <span class="author-initials">{{ review.initials }}</span>
            </div>
            <div>
              <h4 class="author-name">{{ review.name }}</h4>
              <span class="author-role">{{ review.role }}</span>
            </div>
          </div>
        </div>
      </div>
      </template>

      <!-- View All Button -->
      <div v-if="!loadingReviews && !reviewsError && reviews.length > 0" class="view-all-wrapper">
        <router-link to="/reviews" class="view-all-button">
          Открыть отзывы
        </router-link>
      </div>
    </section>

    <!-- Contacts & Form Section -->
    <section class="contacts-section">
      <div class="contacts-grid">
        <!-- Contact Cards -->
        <div class="contact-cards">
          <div class="section-label">
            <span>/ contact</span>
          </div>
          <h2 class="section-title">Контакты</h2>

          <!-- Email Card -->
          <div class="contact-card">
            <div class="contact-label">Email</div>
            <div class="contact-value">hello@greencode.studio</div>
          </div>

          <!-- Phone Card -->
          <div class="contact-card">
            <div class="contact-label">Телефон</div>
            <div class="contact-value">+7 (999) 123-45-67</div>
          </div>
        </div>

        <!-- Form -->
        <div class="form-section">
          <div class="section-label">
            <span>/ application</span>
          </div>
          <h2 class="section-title form-title">Заполнить заявку</h2>

          <div class="form-card">
            <form class="form-sections" @submit.prevent="submitForm">
              <!-- Contact Info -->
              <div class="form-section-item">
                <h3 class="form-section-title">Контактные данные</h3>
                <div class="form-divider"></div>
              </div>

              <!-- Form Fields -->
              <div class="form-fields">
                <div class="form-field">
                  <input v-model="name" type="text" placeholder="Имя *" class="form-input" :class="fieldClass('name')" />
                  <p v-if="fieldErrors.name" class="field-error">{{ fieldErrors.name }}</p>
                </div>
                <div class="form-field">
                  <input :value="email" @input="handleEmailInput" type="email" placeholder="Email *" class="form-input" :class="fieldClass('email')" />
                  <p v-if="fieldErrors.email" class="field-error">{{ fieldErrors.email }}</p>
                </div>
              </div>

              <!-- Phone -->
              <div class="form-field">
                <input :value="phone" @input="formatPhone" type="tel" placeholder="Телефон *" class="form-input" :class="fieldClass('phone')" maxlength="18" />
                <p v-if="fieldErrors.phone" class="field-error">{{ fieldErrors.phone }}</p>
              </div>

              <!-- Message -->
              <div class="form-section-item">
                <h3 class="form-section-title">Сообщение</h3>
                <div class="form-divider mb-4"></div>
                <div class="form-field">
                  <textarea v-model="message" placeholder="Сообщение" class="form-input form-textarea" maxlength="1000"></textarea>
                  <div class="char-counter">{{ (message || '').length }}/1000</div>
                </div>
              </div>

              <!-- Submit -->
              <div class="form-submit">
                <p v-if="success" class="form-success">Заявка отправлена! Мы свяжемся с вами в ближайшее время.</p>
                <p v-else-if="error" class="form-error">{{ error }}</p>
                <p v-else class="form-agree">
                  Нажимая кнопку, вы соглашаетесь на обработку персональных данных.
                </p>
                <button class="submit-button" :disabled="loading">
                  {{ loading ? 'Отправка...' : 'Отправить заявку' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<style scoped>
.main-page {
  flex: 1;
  position: relative;
}

spline-viewer {
  position: fixed;
  top: 0;
  left: min(500px, 30vw);
  width: 100%;
  height: 100%;
  z-index: -1;
  pointer-events: none;
  opacity: 0.9;
}

@media (max-width: 767px) {
  spline-viewer {
    left: 20vw;
    opacity: 0.5;
  }
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 16px 80px;
  background-size: cover;
  background-position: center top;
  background-repeat: no-repeat;
  border-radius: 40px;
}

@media (min-width: 768px) {
  .hero-section {
    padding: 32px 0 120px 24px;
  }
}

.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 32px;
}

.badge {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  padding: 10px 20px;
  border-radius: 9999px;
  background-color: rgba(68, 148, 74, 0.5);
  border: 1px solid #44944A;
  margin-bottom: 32px;
}

.badge-dot {
  width: 8px;
  height: 16px;
  background-color: #44944A;
  border-radius: 9999px;
}

.badge-text {
  color: #A8E4A0;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.hero-title {
  color: #004524;
  font-size: 48px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: bold;
  line-height: 1.1;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 100px;
  }
}

@media (min-width: 1024px) {
  .hero-title {
    font-size: 138px;
  }
}

.hero-description {
  color: #004524;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.7;
  margin-bottom: 40px;
  max-width: 720px;
}

@media (min-width: 768px) {
  .hero-description {
    font-size: 24px;
    line-height: 1.95;
  }
}

.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  max-width: 261px;
  height: 56px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 20px;
  color: white;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
}

@media (min-width: 768px) {
  .cta-button {
    width: 261px;
    height: 65px;
    font-size: 20px;
  }
}

.cta-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.services-section, .cases-section, .reviews-section, .contacts-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 48px 16px;
}

.video-section {
  width: 100%;
  overflow: hidden;
}

.greencode-video {
  display: block;
  width: 100%;
  height: 200px;
  object-fit: cover;
}

@media (min-width: 768px) {
  .greencode-video {
    height: 250px;
  }
}

@media (min-width: 1280px) {
  .greencode-video {
    height: 300px;
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

.section-title {
  color: #004524;
  font-size: 32px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 40px;
}

@media (min-width: 768px) {
  .section-title {
    font-size: 72px;
    margin-bottom: 64px;
  }
}

.services-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 768px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1280px) {
  .services-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.service-card {
  display: block;
  text-decoration: none;
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 30px;
  padding: 24px;
  border: 1px solid rgba(68, 148, 74, 0.2);
  transition: all 0.3s;
  cursor: pointer;
}

@media (min-width: 768px) {
  .service-card {
    padding: 32px;
  }
}

.service-learn-more {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #44944A;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  margin-top: 20px;
  opacity: 0;
  transform: translateX(-10px);
  transition: all 0.3s;
}

.service-card:hover .service-learn-more {
  opacity: 1;
  transform: translateX(0);
}

.service-learn-more svg {
  transition: transform 0.3s;
}

.service-card:hover .service-learn-more svg {
  transform: translateX(4px);
}

.service-card:hover {
  border-color: rgba(68, 148, 74, 0.5);
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
  font-size: 22px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 12px;
}

@media (min-width: 768px) {
  .service-title {
    font-size: 30px;
  }
}

.service-description {
  color: rgba(255, 255, 255, 0.72);
  font-size: 15px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.6;
}

@media (min-width: 768px) {
  .service-description {
    font-size: 18px;
    line-height: 2;
  }
}

.cases-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
  margin-bottom: 48px;
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

@keyframes caseFadeIn {
  0% { opacity: 0; transform: translateY(60px) scale(0.92); }
  100% { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes casePulse {
  0%, 100% { border-color: rgba(68, 148, 74, 0.2); }
  50% { border-color: rgba(68, 148, 74, 0.4); }
}

@keyframes caseGlow {
  0%, 100% { box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10); }
  50% { box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.05) inset, 0px 0px 40px rgba(0, 255, 102, 0.18); }
}

.case-card {
  display: block;
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 32px;
  overflow: hidden;
  border: 1px solid rgba(68, 148, 74, 0.2);
  transition: border-color 0.5s ease, transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.5s ease;
  cursor: pointer;
  text-decoration: none;
  will-change: transform;
}

.case-card.case-visible {
  animation: caseFadeIn 0.9s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
}

.case-card.case-animated {
  opacity: 1;
  transform: translateY(0) scale(1);
  animation: casePulse 3s ease-in-out infinite, caseGlow 4s ease-in-out infinite;
}

.case-card.case-visible:nth-child(2) { animation-delay: 0.15s; }
.case-card.case-visible:nth-child(3) { animation-delay: 0.3s; }

.case-card.case-animated:nth-child(2) { animation-delay: 0.5s, 0.8s; }
.case-card.case-animated:nth-child(3) { animation-delay: 1s, 1.6s; }

.case-card.case-animated:hover {
  animation: none !important;
}

.case-card:hover {
  border-color: rgba(68, 148, 74, 0.6);
  transform: translateY(-8px) scale(1.03);
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.06) inset, 0px 20px 40px rgba(0, 0, 0, 0.2), 0px 0px 34px rgba(0, 255, 102, 0.15);
}

.case-image {
  width: calc(100% - 32px);
  height: 200px;
  object-fit: cover;
  margin: 16px;
  border-radius: 20px;
  transition: transform 0.5s ease, opacity 0.5s ease;
}

@media (min-width: 768px) {
  .case-image {
    width: calc(100% - 48px);
    height: 280px;
    margin: 24px;
    border-radius: 26px;
  }
}

.case-card:hover .case-image {
  transform: scale(1.04);
  opacity: 0.9;
}

.case-content {
  padding: 0 24px 24px;
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

.case-title {
  color: white;
  font-size: 22px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 12px;
}

@media (min-width: 768px) {
  .case-title {
    font-size: 30px;
  }
}

.case-description {
  color: rgba(255, 255, 255, 0.72);
  font-size: 15px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.6;
  margin-bottom: 16px;
}

@media (min-width: 768px) {
  .case-description {
    font-size: 18px;
    line-height: 2;
  }
}

.view-all-wrapper {
  display: flex;
  justify-content: center;
}

.view-all-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  max-width: 276px;
  height: 56px;
  background-color: white;
  border-radius: 20px;
  color: black;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s;
}

@media (min-width: 768px) {
  .view-all-button {
    width: 276px;
    height: 72px;
    font-size: 20px;
  }
}

.view-all-button:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  transform: scale(1.02);
}

.reviews-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
  margin-bottom: 48px;
}

@media (min-width: 1280px) {
  .reviews-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.review-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 32px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.review-text {
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.8;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .review-text {
    font-size: 24px;
    line-height: 2.5;
    margin-bottom: 32px;
  }
}

.review-author {
  display: flex;
  align-items: center;
  gap: 20px;
}

.author-avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background-color: rgba(0.62, 254.99, 101.98, 0.14);
  display: flex;
  align-items: center;
  justify-content: center;
}

.author-initials {
  color: #004524;
  font-size: 16px;
  font-family: 'IBM Plex Mono', monospace;
}

.author-name {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  font-weight: 500;
}

.author-role {
  color: rgba(255, 255, 255, 0.56);
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.contacts-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 1280px) {
  .contacts-grid {
    grid-template-columns: 1fr 2fr;
  }
}

.contact-cards {
  display: flex;
  flex-direction: column;
}

.contact-card {
  background-color: #004524;
  border-radius: 16px;
  padding: 20px;
  width: 100%;
  max-width: 552px;
  min-height: auto;
  box-sizing: border-box;
  margin-bottom: 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

@media (min-width: 768px) {
  .contact-card {
    padding: 24px;
    min-height: 310px;
  }
}

.contact-card:last-child {
  margin-bottom: 0;
}

.contact-label {
  color: rgba(255, 255, 255, 0.45);
  font-size: 20px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.3);
  padding-bottom: 16px;
}

.contact-value {
  color: white;
  font-size: 22px;
  font-family: 'Space Grotesk', sans-serif;
  text-align: right;
}

@media (min-width: 768px) {
  .contact-value {
    font-size: 30px;
  }
}

.form-section .section-title {
  text-align: right;
}

.form-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 24px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

@media (min-width: 768px) {
  .form-card {
    padding: 40px;
  }
}

.form-sections {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-section-item {
  margin-bottom: 0;
}

.form-section-title {
  color: rgba(255, 255, 255, 0.45);
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 12px;
}

.form-divider {
  height: 1px;
  background-color: white;
  width: 100%;
}

.form-fields {
  display: grid;
  grid-template-columns: 1fr;
  gap: 16px;
}

@media (min-width: 768px) {
  .form-fields {
    grid-template-columns: 1fr 1fr;
  }
}

.form-field {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 22px;
  padding: 20px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.form-input {
  width: 100%;
  background: transparent;
  color: rgba(255, 255, 255, 0.44);
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  border: none;
  outline: none;
}

.form-input--error {
  color: #ff6b6b;
}

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.44);
}

.field-error {
  color: #ff6b6b;
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
  margin-top: 8px;
}

.char-counter {
  color: rgba(255, 255, 255, 0.3);
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
  text-align: right;
  margin-top: 6px;
}

.form-textarea {
  height: 120px;
  resize: none;
}

.form-submit {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 20px;
  margin-top: 20px;
}

@media (min-width: 768px) {
  .form-submit {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}

.form-agree {
  color: rgba(255, 255, 255, 0.44);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  max-width: 400px;
}

.form-error {
  color: #ff6b6b;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.form-success {
  color: #92FFAD;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.submit-button {
  width: 100%;
  max-width: 273px;
  height: 56px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 20px;
  color: white;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  border: none;
  cursor: pointer;
  transition: all 0.3s;
}

@media (min-width: 768px) {
  .submit-button {
    width: 273px;
    height: 70px;
    font-size: 20px;
  }
}

.submit-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.mb-4 {
  margin-bottom: 16px;
}

.text-right {
  text-align: right;
}

.form-title {
  text-align: right;
}

@media (min-width: 1280px) {
  .form-title {
    margin-right: 535px;
  }
}

.spinner-wrapper {
  display: flex;
  justify-content: center;
  padding: 48px 0;
}

.spinner {
  width: 36px;
  height: 36px;
  border: 3px solid rgba(68, 148, 74, 0.2);
  border-top-color: #44944A;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-block {
  text-align: center;
  padding: 32px;
  color: #004524;
  font-family: 'Roboto Mono', monospace;
}

.error-block p {
  font-size: 16px;
  margin-bottom: 16px;
}

.retry-btn {
  padding: 10px 24px;
  background: #44944A;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  cursor: pointer;
  transition: background 0.2s;
}

.retry-btn:hover {
  background: #3a7d3d;
}

.empty-block {
  text-align: center;
  padding: 32px;
  color: #004524;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  opacity: 0.7;
}
</style>