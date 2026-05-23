<script setup>
import { ref, onMounted } from 'vue'
import { reviewsService } from '@/lib/reviewsService'

const showModal = ref(false)
const form = ref({ name: '', role: '', review: '' })
const reviews = ref([])
const loading = ref(true)

onMounted(async () => {
  await fetchReviews()
})

async function fetchReviews() {
  loading.value = true
  const data = await reviewsService.getAll()
  if (data) {
    reviews.value = data
  }
  loading.value = false
}

function getInitials(name) {
  const parts = name.trim().split(/\s+/)
  if (parts.length >= 2) {
    return (parts[0][0] + parts[1][0]).toUpperCase()
  }
  return parts[0].slice(0, 2).toUpperCase()
}

const submitReview = async () => {
  const review = {
    name: form.value.name,
    role: form.value.role || '',
    text: form.value.review,
    initials: getInitials(form.value.name)
  }
  const data = await reviewsService.create(review)
  if (data) {
    reviews.value.unshift(data[0])
  }
  form.value = { name: '', role: '', review: '' }
  showModal.value = false
}
</script>

<template>
  <div class="reviews-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ reviews</span>
          </div>
          <h1 class="hero-title">
            Отзывы клиентов
          </h1>
          <p class="hero-description">
            Мнения партнёров о совместной работе и результатах.
          </p>

          <!-- Back Button -->
          <router-link 
            to="/"
            class="back-button"
          >
            Назад
          </router-link>
        </div>

      </div>
    </section>

    <!-- Reviews Grid -->
    <section class="reviews-section">
      <div class="reviews-grid">
        <div 
          v-for="(review, index) in reviews" 
          :key="review.id || index"
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
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="cta-card">
        <h2 class="cta-title">Хотите оставить отзыв?</h2>
        <p class="cta-description">Нам важно ваше мнение. Поделитесь впечатлениями о сотрудничестве.</p>
        <button 
          @click="showModal = true"
          class="cta-button"
        >
          Оставить отзыв
        </button>

        <!-- Modal -->
        <Teleport to="body">
          <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
            <div class="modal-content">
              <button class="modal-close" @click="showModal = false">×</button>
              <h3 class="modal-title">Оставить отзыв</h3>
              <form @submit.prevent="submitReview" class="modal-form">
                <input 
                  v-model="form.name"
                  type="text" 
                  placeholder="Ваше имя" 
                  class="modal-input"
                  required
                />
                <input 
                  v-model="form.role"
                  type="text" 
                  placeholder="Ваша должность (необязательно)" 
                  class="modal-input"
                />
                <textarea 
                  v-model="form.review"
                  placeholder="Ваш отзыв" 
                  class="modal-textarea"
                  rows="4"
                  required
                ></textarea>
                <button type="submit" class="modal-submit">Отправить</button>
              </form>
            </div>
          </div>
        </Teleport>
      </div>
    </section>
  </div>
</template>

<style scoped>
.reviews-page {
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
  color: #004524;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.hero-title {
  color: #004524;
  font-size: 72px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.1;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 100px;
  }
}

.hero-description {
  color: #004524;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.5;
  margin-bottom: 32px;
}

.back-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 16px 32px;
  background-color: white;
  border-radius: 16px;
  color: #004524;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
}

.back-button:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.reviews-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 0 24px 80px;
}

.reviews-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 768px) {
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
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  line-height: 1.8;
  margin-bottom: 32px;
}

.review-author {
  display: flex;
  align-items: center;
  gap: 20px;
}

.author-avatar {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background-color: rgba(0.62, 254.99, 101.98, 0.14);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.author-initials {
  color: #004524;
  font-size: 16px;
  font-family: 'IBM Plex Mono', monospace;
}

.author-name {
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  font-weight: 500;
  margin-bottom: 4px;
}

.author-role {
  color: rgba(255, 255, 255, 0.56);
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.cta-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 0 24px 80px;
}

.cta-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 48px;
  border: 1px solid rgba(68, 148, 74, 0.2);
  text-align: center;
}

.cta-title {
  color: white;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  margin-bottom: 16px;
}

.cta-description {
  color: rgba(255, 255, 255, 0.7);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 32px;
}

.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 20px 40px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 20px;
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
}

.cta-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

.modal-content {
  background-color: #004524;
  border-radius: 24px;
  padding: 32px;
  max-width: 480px;
  width: 90%;
  position: relative;
  border: 1px solid rgba(68, 148, 74, 0.3);
}

.modal-close {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  color: white;
  font-size: 28px;
  cursor: pointer;
  opacity: 0.7;
}

.modal-close:hover {
  opacity: 1;
}

.modal-title {
  color: white;
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 24px;
}

.modal-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.modal-input,
.modal-textarea {
  padding: 16px;
  border-radius: 12px;
  border: 1px solid rgba(68, 148, 74, 0.3);
  background-color: rgba(0, 0, 0, 0.2);
  color: white;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  outline: none;
}

.modal-input::placeholder,
.modal-textarea::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.modal-input:focus,
.modal-textarea:focus {
  border-color: #44944A;
}

.modal-submit {
  padding: 16px;
  border-radius: 12px;
  background-color: #44944A;
  color: white;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  border: none;
  cursor: pointer;
  transition: all 0.3s;
}

.modal-submit:hover {
  background-color: #3a7d3d;
}
</style>