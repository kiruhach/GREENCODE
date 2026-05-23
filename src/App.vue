<script setup>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
</script>

<template>
  <div class="app-container">
    <!-- Header -->
    <Header />

    <!-- Main Content -->
    <main class="main-content">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<style scoped>
.app-container {
  min-height: 100vh;
  background-color: #A8E4A0;
  position: relative;
  overflow-x: hidden;
}

.main-content {
  padding-top: 106px;
  position: relative;
  z-index: 5;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>