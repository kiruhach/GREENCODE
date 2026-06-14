<script setup>
import { ref } from 'vue'
import { supabase } from '@/lib/supabase'
import contactBg from '@/assets/images/contact.webp?url'

const email = ref('')
const phone = ref('')
const name = ref('')
const company = ref('')
const message = ref('')
const loading = ref(false)
const success = ref(false)
const error = ref('')

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

async function submitForm() {
  if (!name.value.trim()) {
    error.value = 'Укажите ваше имя'
    return
  }

  loading.value = true
  error.value = ''

  const { error: err } = await supabase
    .from('applications')
    .insert({
      name: name.value,
      email: email.value || null,
      phone: phone.value || null,
      company: company.value || null,
      message: message.value || null
    })

  loading.value = false

  if (err) {
    error.value = 'Ошибка при отправке. Попробуйте ещё раз.'
    console.error('Supabase error:', err)
  } else {
    success.value = true
    name.value = ''
    email.value = ''
    phone.value = ''
    company.value = ''
    message.value = ''
  }
}
</script>

<template>
  <div class="contacts-page">
    <!-- Hero Section -->
    <section class="hero-section" :style="{ backgroundImage: `url(${contactBg})` }">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ contacts</span>
          </div>
          <h1 class="hero-title">
            Контакты и удобный путь до заявки
          </h1>
        </div>

      </div>
    </section>

    <!-- Contact Info & Form -->
    <section class="contact-section">
      <div class="contact-grid">
        <!-- Left: Contact Cards -->
        <div class="contact-cards">
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

          <!-- Messengers Card -->
          <div class="contact-card">
            <div class="contact-label">Мессенджеры</div>
            <div class="contact-value">Telegram / VK</div>
          </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="form-card">
          <span class="form-label">/ request form</span>
          <h2 class="form-title">Заполнить заявку</h2>

          <form @submit.prevent="submitForm">
            <!-- Contact Info Section -->
            <div class="form-section">
              <h3 class="form-section-title">Контактные данные</h3>
              <div class="form-divider"></div>
            </div>

            <!-- Name & Email -->
            <div class="form-fields">
              <div class="form-field">
                <input v-model="name" type="text" placeholder="Имя" class="form-input" />
              </div>
              <div class="form-field">
                <input :value="email" @input="handleEmailInput" type="email" placeholder="Email" class="form-input" />
              </div>
            </div>

            <!-- Phone -->
            <div class="form-field">
              <input :value="phone" @input="formatPhone" type="tel" placeholder="Телефон" class="form-input" maxlength="18" />
            </div>

            <!-- Company Section -->
            <div class="form-section">
              <h3 class="form-section-title">О компании</h3>
              <div class="form-divider"></div>
            </div>

            <!-- Company Field -->
            <div class="form-field">
              <input v-model="company" type="text" placeholder="Компания / ниша" class="form-input" />
            </div>

            <!-- Task Section -->
            <div class="form-section">
              <h3 class="form-section-title">Задача</h3>
              <div class="form-divider"></div>
            </div>

            <!-- Task Description -->
            <div class="form-field form-textarea-field">
              <textarea v-model="message" placeholder="Опишите задачу: запуск нового сайта, SEO, ребрендинг, улучшение конверсии или комплексная работа" class="form-input form-textarea"></textarea>
            </div>

            <!-- Submit -->
            <div class="form-submit">
              <p v-if="success" class="form-success">Заявка отправлена! Мы свяжемся с вами в ближайшее время.</p>
              <p v-else-if="error" class="form-error">{{ error }}</p>
              <p v-else class="form-agree">
                Нажимая кнопку, вы соглашаетесь на обработку персональных данных и получение обратной связи по проекту.
              </p>
              <button class="submit-button" :disabled="loading">
                {{ loading ? 'Отправка...' : 'Отправить заявку' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
      <div class="map-container">
        <iframe
          src="https://yandex.ru/map-widget/v1/?ll=131.885%2C43.115&z=12&pt=131.885%2C43.115%2Cpm2rdm"
          width="100%"
          height="450"
          style="border:0; border-radius: 30px;"
          allowfullscreen
          loading="lazy"
          title="Яндекс.Карта"
        ></iframe>
      </div>
    </section>
  </div>
</template>

<style scoped>
.contacts-page {
  flex: 1;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 24px 64px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 800px;
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
  color: #004524;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.hero-title {
  color: #004524;
  font-size: 48px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.1;
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

.hero-right {
  display: none;
}

@media (min-width: 1280px) {
  .hero-right {
    display: flex;
    justify-content: flex-end;
  }
}

.hero-image {
  width: 100%;
  max-width: 800px;
  height: auto;
  border-radius: 40px;
  object-fit: cover;
}

.contact-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 1280px) {
  .contact-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.contact-cards {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.contact-card {
  background-color: #004524;
  border-radius: 16px;
  padding: 24px;
  width: 100%;
  max-width: 552px;
  min-height: 266px;
  box-sizing: border-box;
  margin-bottom: 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
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
  font-size: 30px;
  font-family: 'Space Grotesk', sans-serif;
  text-align: right;
}

.form-card {
  background-color: #004524;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 36px;
  padding: 40px;
  border: 1px solid rgba(68, 148, 74, 0.2);
  min-height: 900px;
}

.form-label {
  display: block;
  color: #92FFAD;
  font-size: 14px;
  font-family: 'IBM Plex Mono', monospace;
  margin-bottom: 16px;
}

.form-title {
  color: white;
  font-size: 48px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .form-title {
    font-size: 62px;
  }
}

.form-section {
  margin-bottom: 24px;
}

.form-section-title {
  color: rgba(255, 255, 255, 0.45);
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 8px;
  margin-top: 16px;
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
  margin-bottom: 16px;
}

@media (min-width: 768px) {
  .form-fields {
    grid-template-columns: repeat(2, 1fr);
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
  color: rgba(255, 255, 255, 0.5);
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  border: none;
  outline: none;
}

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.form-textarea-field {
  min-height: 120px;
}

.form-textarea {
  height: 80px;
  resize: none;
}

.form-submit {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 24px;
  margin-top: 24px;
}

@media (min-width: 768px) {
  .form-submit {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}

.form-agree {
  color: rgba(255, 255, 255, 0.45);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  max-width: 450px;
}

.submit-button {
  padding: 20px 32px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 22px;
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.3s;
}

.submit-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
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

.map-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px 80px;
}

.map-container {
  border-radius: 30px;
  overflow: hidden;
  box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10);
}

.map-container iframe {
  display: block;
}
</style>