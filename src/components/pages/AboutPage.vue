<script setup>
import teamImage from '@/assets/images/team.webp?url';

const mainCards = [
  {
    label: '/  who are we',
    title: 'Маленькая сильная команда полного цикла',
    description: 'Работаем как единая продуктовая группа: вместе проектируем, пишем, запускаем и измеряем. Поэтому дизайн не отрывается от разработки, а SEO — от контента и структуры.'
  },
  {
    label: '/  approach',
    title: 'Не делим проект на «красиво» и «эффективно»',
    description: 'Сильная подача и понятная бизнес-логика должны работать вместе. Поэтому в каждом проекте у нас есть визуальная система, сценарии доверия и аналитическая основа.'
  },
  {
    label: '/  result',
    title: 'Делаем не страницы, а рабочие цифровые активы',
    description: 'На выходе клиент получает не только визуально сильный продукт, но и систему, готовую к продвижению, тестам и масштабированию.'
  }
]

const values = [
  { letter: 'A', title: 'Чистая архитектура и понятная структура продукта' },
  { letter: 'B', title: 'Сильный визуальный язык без перегруза' },
  { letter: 'C', title: 'Продуманная SEO- и контентная база с первого дня' },
  { letter: 'D', title: 'Решения, привязанные к метрикам и воронке' }
]

const workflow = [
  { step: '#01', text: 'Разбираем задачу, аудиторию, рынок и текущую ситуацию.' },
  { step: '#02', text: 'Собираем структуру, дизайн-сценарии и основу для запуска.' },
  { step: '#03', text: 'Внедряем, отслеживаем метрики и усиливаем результат.' }
]

const reasons = [
  'Мы говорим языком бизнеса, а не только визуала.',
  'Не дробим проект между пятью подрядчиками и не теряем скорость.',
  'Закладываем основу для дальнейшего роста сразу на старте.'
]
</script>


<template>
  <div class="about-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ about</span>
          </div>
          <h1 class="hero-title">
            О нас — команде, которая превращает цифровой хаос в систему роста
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
          <img v-fade-in :src="teamImage" alt="Team" class="hero-image-placeholder" />
        </div>
      </div>
    </section>

    <!-- Three Main Cards -->
    <section class="cards-section">
      <div class="cards-grid">
        <div 
          v-for="(card, index) in mainCards" 
          :key="index"
          class="main-card"
        >
          <span class="card-label">{{ card.label }}</span>
          <h3 class="card-title">{{ card.title }}</h3>
          <p class="card-description">{{ card.description }}</p>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
      <div class="values-card">
        <span class="section-label-light">/ values</span>
        <h2 class="values-title">На чём держится наша работа</h2>

        <div class="values-grid">
          <div 
            v-for="(value, index) in values" 
            :key="index"
            class="value-item"
          >
            <span class="value-letter">{{ value.letter }}</span>
            <h4 class="value-title">{{ value.title }}</h4>
          </div>
        </div>
      </div>
    </section>

    <!-- Numbers Section -->
    <section class="numbers-section">
      <div class="numbers-grid">
        <!-- Numbers -->
        <div class="numbers-card">
          <span class="section-label-light">/ numbers</span>
          <div class="numbers-list">
            <div class="number-item">
              <span class="number-label">Фокус</span>
              <span class="number-value">B2B, сервисы, digital</span>
            </div>
            <div class="number-item">
              <span class="number-label">Состав</span>
              <span class="number-value">Стратегия + дизайн + SEO</span>
            </div>
            <div class="number-item">
              <span class="number-label">Подход</span>
              <span class="number-value">Запуск → измерение → усиление</span>
            </div>
          </div>
        </div>

        <!-- Workflow & Why -->
        <div class="workflow-section">
          <!-- Workflow -->
          <div class="workflow-card">
            <span class="section-label-light">/ workflow</span>
            <h3 class="workflow-title">Как мы строим работу с проектом</h3>
            <div class="workflow-list">
              <div v-for="(step, index) in workflow" :key="index" class="workflow-item">
                <span class="workflow-step">{{ step.step }}</span>
                <span class="workflow-text">{{ step.text }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Clients Stay -->
    <section class="reasons-section">
      <div class="reasons-card">
        <span class="section-label-light">/ why clients stay</span>
        <h3 class="reasons-title">Почему с нами остаются надолго</h3>
        <div class="reasons-list">
          <div v-for="(reason, index) in reasons" :key="index" class="reason-item">
            <span class="reason-text">{{ reason }}</span>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.about-page {
  min-height: 100vh;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px 64px;
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

.section-label-light {
  display: block;
  color: #92FFAD;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 16px;
}

.hero-title {
  color: #004524;
  font-size: 32px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.1;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 72px;
  }
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 72px;
  }
}

@media (min-width: 1024px) {
  .hero-title {
    font-size: 104px;
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
  width: 100%;
  max-width: 800px;
  height: auto;
  aspect-ratio: 800 / 462;
  border-radius: 40px;
  object-fit: cover;
  margin-left: auto;
  margin-top: 150px;
  display: block;
}

@media (max-width: 767px) {
  .hero-image-placeholder {
    margin-top: 40px;
    aspect-ratio: 800 / 462;
  }
}

.cards-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.cards-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 768px) {
  .cards-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.main-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 32px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.card-label {
  display: block;
  color: #92FFAD;
  font-size: 12px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 16px;
}

.card-title {
  color: white;
  font-size: 36px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 16px;
  line-height: 1.25;
}

@media (min-width: 768px) {
  .card-title {
    font-size: 42px;
  }
}

.card-description {
  color: rgba(255, 255, 255, 0.7);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2;
}

.values-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.values-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 40px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.values-title {
  color: white;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 40px;
}

@media (min-width: 768px) {
  .values-title {
    font-size: 68px;
  }
}

.values-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 768px) {
  .values-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.value-item {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 24px;
  padding: 24px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  transition: background-color 0.3s;
}

.value-item:hover {
  background-color: rgba(255, 255, 255, 0.08);
}

.value-letter {
  display: block;
  color: #44944A;
  font-size: 12px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 12px;
}

.value-title {
  color: white;
  font-size: 28px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.5;
}

.numbers-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.numbers-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 1280px) {
  .numbers-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.numbers-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.numbers-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.number-item {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 22px;
  padding: 20px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.number-label {
  display: block;
  color: rgba(255, 255, 255, 0.45);
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
  margin-bottom: 8px;
}

.number-value {
  color: white;
  font-size: 32px;
  font-family: 'Roboto Mono', monospace;
}

.workflow-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.workflow-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.workflow-title {
  color: white;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .workflow-title {
    font-size: 62px;
  }
}

.workflow-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.workflow-item {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 24px;
  padding: 20px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.workflow-step {
  display: block;
  color: #44944A;
  font-size: 12px;
  font-family: 'IBM Plex Mono', monospace;
  margin-bottom: 8px;
}

.workflow-text {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2.25;
}

.reasons-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px 80px;
}

.reasons-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 32px;
  border: 1px solid rgba(68, 148, 74, 0.2);
}

.reasons-title {
  color: white;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .reasons-title {
    font-size: 62px;
  }
}

.reasons-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.reason-item {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 24px;
  padding: 24px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.reason-text {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2.25;
}
</style>