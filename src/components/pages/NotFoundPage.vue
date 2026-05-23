<script setup>
</script>

<template>
  <div class="not-found-page">
    <div class="not-found-content">
      <h1 class="error-code">404</h1>
      <p class="error-message">Страница не найдена</p>
      <router-link 
        to="/"
        class="home-button"
      >
        На главную
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.not-found-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.not-found-content {
  text-align: center;
}

.error-code {
  color: #004524;
  font-size: 100px;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  line-height: 1;
  margin-bottom: 32px;
}

@media (min-width: 768px) {
  .error-code {
    font-size: 200px;
  }
}

.error-message {
  color: #004524;
  font-size: 24px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 32px;
}

.home-button {
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

.home-button:hover {
  background-color: #3a7d3d;
  transform: scale(1.02);
}
</style>