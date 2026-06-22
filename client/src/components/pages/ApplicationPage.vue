<script setup>
import { ref } from 'vue'
import { applicationsService } from '@/lib/applicationsService'
import checkMarkIcon from '@/assets/icons/check_mark.svg?url'

const services = ['Сайт', 'SEO', 'Брендинг', 'Контент', 'Аналитика', 'Дизайн']
const selectedServices = ref([])

const name = ref('')
const email = ref('')
const phone = ref('')
const company = ref('')
const message = ref('')
const taskDetails = ref('')
const budget = ref('')
const timeframe = ref('')
const contactFormat = ref('')
const emailError = ref('')

const timeframes = ['1 месяц', '2 месяца', '3 месяца', '4 месяца', '5 месяцев', '6 месяцев', 'Более 6 месяцев']
const contactFormats = ['Телефон', 'Email']

const handleBudgetInput = (e) => {
  const value = e.target.value.replace(/\D/g, '')
  budget.value = value
}

const formatBudget = () => {
  if (budget.value) {
    return budget.value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' ₽'
  }
  return ''
}

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

const loading = ref(false)
const success = ref(false)
const error = ref('')
const fieldErrors = ref({})

const toggleService = (service) => {
  const index = selectedServices.value.indexOf(service)
  if (index === -1) {
    selectedServices.value.push(service)
  } else {
    selectedServices.value.splice(index, 1)
  }
}

function validate() {
  const errs = {}
  if (!name.value.trim()) errs.name = 'Укажите ваше имя'
  if (!email.value.trim()) errs.email = 'Укажите email'
  else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) errs.email = 'Некорректный email'
  if (!phone.value.trim()) errs.phone = 'Укажите телефон'
  else if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone.value)) errs.phone = 'Некорректный телефон'
  if (!contactFormat.value) errs.contactFormat = 'Выберите формат связи'
  if (!selectedServices.value.length) errs.services = 'Выберите хотя бы одну услугу'
  fieldErrors.value = errs
  return Object.keys(errs).length === 0
}

function fieldClass(field) {
  return { 'form-input--error': fieldErrors.value[field] }
}

async function submitForm() {
  if (!validate()) return

  loading.value = true
  error.value = ''
  fieldErrors.value = {}

  try {
    await applicationsService.create({
      name: name.value,
      email: email.value || null,
      phone: phone.value || null,
      company: company.value || null,
      message: message.value || null,
      task_details: taskDetails.value || null,
      timeframe: timeframe.value || null,
      budget: budget.value ? budget.value + ' ₽' : null,
      contact_format: contactFormat.value || null,
      services: selectedServices.value
    })
    loading.value = false
    success.value = true
    name.value = ''
    email.value = ''
    phone.value = ''
    company.value = ''
    message.value = ''
    taskDetails.value = ''
    budget.value = ''
    timeframe.value = ''
    contactFormat.value = ''
    selectedServices.value = []
  } catch (err) {
    if (err.response?.status === 422 && err.response.data?.errors) {
      const serverErrors = err.response.data.errors
      const mapped = {}
      for (const field of Object.keys(serverErrors)) {
        mapped[field] = serverErrors[field][0]
      }
      fieldErrors.value = mapped
    } else {
      error.value = 'Ошибка при отправке. Попробуйте ещё раз.'
    }
  }
  loading.value = false
}
</script>

<template>
  <div class="application-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-grid">
        <!-- Left Column -->
        <div class="hero-left">
          <div class="section-label">
            <span>/ application</span>
          </div>
          <h1 class="hero-title">
            Оставить заявку и быстро запустить следующий шаг
          </h1>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content-section">
      <div class="content-grid">
        <!-- Left Info Cards -->
        <div class="info-cards">
          <!-- Card 1 -->
          <div class="info-card">
            <span class="card-label">/ fast start</span>
            <h3 class="card-title">Помогаем сформулировать задачу, даже если бриф ещё сырой</h3>
            <p class="card-description">Можно прийти с идеей, проблемой или набором ссылок — разложим по полочкам и подскажем лучший маршрут.</p>
          </div>

          <!-- Card 2 -->
          <div class="info-card">
            <span class="card-label">/ clarity</span>
            <h3 class="card-title">Возвращаемся не с «окей», а с понятным планом</h3>
            <p class="card-description">После заявки вы понимаете, какие этапы нужны проекту, что можно запустить быстро, а что лучше делать поэтапно.</p>
          </div>

          <!-- Card 3 -->
          <div class="info-card">
            <span class="card-label">/ fit</span>
            <h3 class="card-title">Подходит и для точечных задач, и для полного digital-цикла</h3>
            <p class="card-description">Если нужен редизайн одной страницы — отлично. Если нужен системный рост — тоже берём в работу.</p>
          </div>
        </div>

        <!-- Right: Form -->
        <div class="form-card">
          <div class="form-header">
            <span class="form-label">/ project request</span>
            <span class="form-badge">new brief</span>
          </div>

          <h2 class="form-title">Заполнить бриф</h2>

          <!-- Contact Info Section -->
          <div class="form-section">
            <h3 class="form-section-title">Контактные данные</h3>
            <div class="form-divider"></div>
          </div>

          <!-- Name & Email -->
          <div class="form-fields">
            <div class="form-field">
              <input v-model="name" type="text" placeholder="Имя *" maxlength="30" class="form-input" :class="fieldClass('name')" />
              <p v-if="fieldErrors.name" class="field-error">{{ fieldErrors.name }}</p>
            </div>
            <div class="form-field">
              <input :value="email" @input="handleEmailInput" type="email" placeholder="Email *" class="form-input" :class="fieldClass('email')" />
              <p v-if="fieldErrors.email" class="field-error">{{ fieldErrors.email }}</p>
            </div>
          </div>

          <!-- Phone & Company -->
          <div class="form-fields">
            <div class="form-field">
              <input :value="phone" @input="formatPhone" type="tel" placeholder="Телефон *" class="form-input" :class="fieldClass('phone')" maxlength="18" />
              <p v-if="fieldErrors.phone" class="field-error">{{ fieldErrors.phone }}</p>
            </div>
            <div class="form-field">
              <input v-model="company" type="text" placeholder="Компания" class="form-input" />
            </div>
          </div>

          <!-- Services Section -->
          <div class="form-section">
            <h3 class="form-section-title">Выбор услуг</h3>
            <div class="form-divider"></div>
          </div>

          <!-- Service Tags -->
          <div class="service-tags">
            <div 
              v-for="service in services" 
              :key="service" 
              class="service-tag"
              :class="{ 'service-tag--selected': selectedServices.includes(service) }"
              @click="toggleService(service)"
            >
              <img v-if="selectedServices.includes(service)" :src="checkMarkIcon" alt="check" class="service-check" loading="lazy" />
              <span class="service-text">{{ service }}</span>
            </div>
          </div>
          <p v-if="fieldErrors.services" class="field-error">{{ fieldErrors.services }}</p>

          <!-- Task Section -->
          <div class="form-section">
            <h3 class="form-section-title">Задача</h3>
            <div class="form-divider"></div>
          </div>

          <!-- Task Result -->
          <div class="form-field form-textarea-field">
            <textarea v-model="message" placeholder="Какой результат нужен: больше заявок, запуск нового продукта, рост органики, переупаковка бренда" class="form-input form-textarea" maxlength="1000"></textarea>
            <div class="char-counter">{{ (message || '').length }}/1000</div>
          </div>

          <!-- Task Details -->
          <div class="form-field form-textarea-field-lg">
            <textarea v-model="taskDetails" placeholder="Опишите задачу подробнее: текущая ситуация, ограничения, дедлайны, ожидания." class="form-input form-textarea" maxlength="2000"></textarea>
            <div class="char-counter">{{ (taskDetails || '').length }}/2000</div>
          </div>

          <!-- Parameters Section -->
          <div class="form-section">
            <h3 class="form-section-title">Параметры проекта</h3>
            <div class="form-divider"></div>
          </div>

          <!-- Dates & Budget -->
          <div class="form-fields">
            <div class="form-field">
              <select v-model="timeframe" class="form-input form-select">
                <option value="" disabled>Ориентир по срокам</option>
                <option v-for="tf in timeframes" :key="tf" :value="tf">{{ tf }}</option>
              </select>
            </div>
            <div class="form-field">
              <div class="budget-input-wrapper">
                <input 
                  :value="formatBudget()" 
                  @input="handleBudgetInput" 
                  type="text" 
                  placeholder="Ориентир по бюджету" 
                  class="form-input" 
                />
              </div>
            </div>
          </div>

          <!-- Contact Format -->
          <div class="form-field">
            <select v-model="contactFormat" class="form-input form-select">
              <option value="" disabled>Предпочтительный формат связи *</option>
              <option v-for="cf in contactFormats" :key="cf" :value="cf">{{ cf }}</option>
            </select>
            <p v-if="fieldErrors.contactFormat" class="field-error">{{ fieldErrors.contactFormat }}</p>
          </div>

          <!-- Submit -->
          <div class="form-submit">
            <p v-if="error" class="form-error">{{ error }}</p>
            <p v-if="success" class="form-success">Заявка отправлена! Мы свяжемся с вами в ближайшее время.</p>
            <p class="form-agree">
              Оставляя заявку, вы соглашаетесь на обработку персональных данных.
            </p>
            <button @click="submitForm" class="submit-button" :disabled="loading">
              {{ loading ? 'Отправка...' : 'Отправить заявку' }}
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.application-page {
  flex: 1;
}

.hero-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 32px 16px 48px;
  border-radius: 40px;
  animation: heroFadeIn 0.8s ease-out;
}

@media (min-width: 768px) {
  .hero-section {
    padding: 32px 24px 64px;
  }
}

.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
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
  font-size: 32px;
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
    font-size: 98px;
  }
}

.content-section {
  max-width: 1920px;
  margin: 0 auto;
  padding: 40px 24px 80px;
}

.content-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 1280px) {
  .content-grid {
    grid-template-columns: 1fr 2fr;
  }
}

.info-cards {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.info-card {
  background-color: #004524;
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
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 12px;
  line-height: 1.25;
}

@media (min-width: 768px) {
  .card-title {
    font-size: 40px;
    margin-bottom: 16px;
  }
}

.card-description {
  color: rgba(255, 255, 255, 0.7);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  line-height: 2;
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

.form-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.form-label {
  color: #92FFAD;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.form-badge {
  padding: 8px 16px;
  background-color: rgba(68, 148, 74, 0.12);
  border-radius: 9999px;
  color: rgba(255, 255, 255, 0.75);
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.form-title {
  color: white;
  font-size: 28px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1.15;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .form-title {
    font-size: 68px;
    margin-bottom: 32px;
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
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .form-fields {
    grid-template-columns: repeat(2, 1fr);
  }
}

.form-field {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 22px;
  padding: 16px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

@media (min-width: 768px) {
  .form-field {
    padding: 20px;
  }
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

.form-input--error {
  color: #ff6b6b;
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

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.form-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(255,255,255,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 36px;
  cursor: pointer;
}

.form-select option {
  background: #1a1a1a;
  color: #fff;
}

.form-textarea-field {
  min-height: 100px;
  margin-bottom: 24px;
}

.form-textarea-field-lg {
  min-height: 140px;
  margin-bottom: 24px;
}

.form-textarea {
  height: 64px;
  resize: none;
}

.form-textarea-field-lg .form-textarea {
  height: 96px;
}

.service-tags {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .service-tags {
    grid-template-columns: repeat(3, 1fr);
  }
}

.service-tag {
  background-color: rgba(255, 255, 255, 0.04);
  border-radius: 22px;
  padding: 20px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background-color 0.3s;
  cursor: pointer;
}

.service-tag:hover {
  background-color: rgba(255, 255, 255, 0.08);
}

.service-tag--selected {
  background-color: rgba(68, 148, 74, 0.3);
  border-color: rgba(68, 148, 74, 0.5);
}

.service-tag--selected:hover {
  background-color: rgba(68, 148, 74, 0.4);
}

.service-check {
  width: 20px;
  height: 20px;
}

.service-text {
  color: rgba(255, 255, 255, 0.7);
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
}

.service-tag--selected .service-text {
  color: white;
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
  max-width: 520px;
}

.form-error {
  color: #ff6b6b;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.form-success {
  color: #44944A;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
}

.submit-button {
  width: 100%;
  height: 60px;
  background-color: #44944A;
  box-shadow: 0px 0px 36px rgba(0, 255, 102, 0.24);
  border-radius: 24px;
  color: white;
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.3s;
}

@media (min-width: 768px) {
  .submit-button {
    width: 265px;
    height: 78px;
    font-size: 20px;
  }
}

.submit-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}
</style>