<script setup>
import { ref, onMounted } from 'vue'

const displayText = ref('')
const fullText = '404'

onMounted(() => {
  let i = 0
  const interval = setInterval(() => {
    displayText.value = fullText.slice(0, i + 1)
    i++
    if (i >= fullText.length) clearInterval(interval)
  }, 200)
})
</script>

<template>
  <div class="not-found-page">
    <div class="not-found-content">
      <div class="badge">
        <span class="badge-dot"></span>
        <span class="badge-text">ошибка</span>
      </div>

      <h1 class="error-code">
        <span v-for="(char, i) in displayText" :key="i" class="char" :style="{ animationDelay: i * 0.2 + 's' }">{{ char }}</span>
        <span v-if="displayText.length < fullText.length" class="cursor">|</span>
      </h1>

      <p class="error-message">Страница не найдена</p>
      <p class="error-hint">Возможно, её никогда не существовало или она переехала</p>

      <router-link to="/" class="cta-button">
        На главную
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.not-found-page {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
}

.not-found-content {
  text-align: center;
  max-width: 600px;
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

.error-code {
  color: #004524;
  font-size: 100px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: bold;
  line-height: 1;
  margin-bottom: 24px;
  min-height: 1.1em;
}

@media (min-width: 768px) {
  .error-code {
    font-size: 200px;
  }
}

.char {
  display: inline-block;
  animation: charPop 0.3s ease-out both;
}

@keyframes charPop {
  from {
    opacity: 0;
    transform: translateY(-20px) scale(0.8);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.cursor {
  animation: blink 0.8s step-end infinite;
  color: #44944A;
}

@keyframes blink {
  50% { opacity: 0; }
}

.error-message {
  color: #004524;
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 12px;
}

.error-hint {
  color: #44944A;
  font-size: 16px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 40px;
  opacity: 0.8;
}

.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 261px;
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
    height: 65px;
    font-size: 20px;
  }
}

.cta-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}
</style>