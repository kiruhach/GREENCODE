<script setup>
import { ref } from 'vue'
import logoIcon from '@/assets/icons/logo.svg?url'

const mobileMenuOpen = ref(false)

const navItems = [
  { path: '/services', label: 'Услуги' },
  { path: '/cases', label: 'Кейсы' },
  { path: '/about', label: 'О нас' },
  { path: '/contacts', label: 'Контакты' }
]
</script>

<template>
  <header class="header">
    <div class="header-inner">
      <!-- Logo -->
      <router-link to="/" class="logo-link">
        <img :src="logoIcon" alt="Greencode" class="logo-img" loading="lazy" />
      </router-link>

      <!-- Navigation -->
      <nav class="nav-desktop">
        <router-link 
          v-for="item in navItems" 
          :key="item.path"
          :to="item.path"
          class="nav-link"
        >
          {{ item.label }}
        </router-link>
      </nav>

      <!-- CTA Button -->
      <router-link 
        to="/application"
        class="cta-button"
      >
        Оставить заявку
      </router-link>

      <!-- Mobile menu button -->
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-menu-btn">
        <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div v-if="mobileMenuOpen" class="mobile-menu">
      <router-link 
        v-for="item in navItems" 
        :key="item.path"
        :to="item.path"
        @click="mobileMenuOpen = false"
        class="mobile-nav-link"
      >
        {{ item.label }}
      </router-link>
      <router-link 
        to="/application"
        @click="mobileMenuOpen = false"
        class="mobile-cta-button"
      >
        Оставить заявку
      </router-link>
    </div>
  </header>
</template>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 50;
  background-color: #004524;
  box-shadow: 0px 0px 34px rgba(0, 255, 102, 0.10);
  border-radius: 0 0 28px 28px;
  margin: 0 16px;
  margin-top: 0;
  outline: 1px solid rgba(68, 148, 74, 0.2);
  outline-offset: -1px;
}

.header-inner {
  max-width: 1920px;
  margin: 0 auto;
  padding: 0 24px;
  height: 90px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}

.logo-img {
  height: 28px;
  width: auto;
}

.logo-box {
  width: 48px;
  height: 48px;
  border-radius: 16px;
  background-color: rgba(0.62, 254.99, 101.98, 0.12);
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-text {
  color: #004524;
  font-size: 14px;
  font-family: 'IBM Plex Mono', monospace;
}

.logo-info {
  display: flex;
  flex-direction: column;
}

.logo-name {
  color: white;
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: bold;
  letter-spacing: 2.24px;
}

.logo-subtitle {
  color: rgba(255, 255, 255, 0.56);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
}

.nav-desktop {
  display: none;
}

@media (min-width: 1024px) {
  .nav-desktop {
    display: flex;
    align-items: center;
    gap: 16px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
  }
}

.nav-link {
  padding: 10px 16px;
  border-radius: 12px;
  background-color: rgba(0, 255, 102, 0.08);
  outline: 1px solid rgba(0, 255, 102, 0.22);
  outline-offset: -1px;
  color: rgba(255, 255, 255, 0.72);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.3s;
}

.nav-link:hover {
  background-color: rgba(0, 255, 102, 0.15);
}

.cta-button {
  display: none;
}

@media (min-width: 1024px) {
  .cta-button {
    display: flex;
    width: 175px;
    height: 42px;
    border-radius: 12px;
    background-color: rgba(0, 255, 102, 0.08);
    outline: 1px solid rgba(0, 255, 102, 0.22);
    outline-offset: -1px;
    color: rgba(255, 255, 255, 0.72);
    font-size: 14px;
    font-family: 'Roboto Mono', monospace;
    text-decoration: none;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
  }

  .cta-button:hover {
    background-color: rgba(0, 255, 102, 0.15);
  }
}

.mobile-menu-btn {
  display: block;
  background: none;
  border: none;
  padding: 8px;
  cursor: pointer;
}

@media (min-width: 1024px) {
  .mobile-menu-btn {
    display: none;
  }
}

.menu-icon {
  width: 24px;
  height: 24px;
  color: white;
}

.mobile-menu {
  display: block;
  padding: 16px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  background-color: #004524;
}

@media (min-width: 1024px) {
  .mobile-menu {
    display: none;
  }
}

.mobile-nav-link {
  display: block;
  padding: 12px 16px;
  border-radius: 12px;
  background-color: rgba(0, 255, 102, 0.08);
  color: rgba(255, 255, 255, 0.72);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  margin-bottom: 12px;
}

.mobile-cta-button {
  display: block;
  width: 100%;
  padding: 12px;
  border-radius: 12px;
  background-color: #44944A;
  color: white;
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  text-align: center;
  text-decoration: none;
}
</style>