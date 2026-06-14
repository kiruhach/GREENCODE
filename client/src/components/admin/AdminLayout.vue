<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { getSession, signOut } from '@/lib/auth'
import dashboardIcon from '@/assets/icons/dashboard.svg?url'
import casesIcon from '@/assets/icons/cases.svg?url'
import servicesIcon from '@/assets/icons/services.svg?url'
import reviewsIcon from '@/assets/icons/reviews.svg?url'
import formIcon from '@/assets/icons/form.svg?url'

const router = useRouter()
const route = useRoute()

const navItems = [
  { path: '/admin', label: 'Дашборд', icon: dashboardIcon },
  { path: '/admin/cases', label: 'Кейсы', icon: casesIcon },
  { path: '/admin/services', label: 'Услуги', icon: servicesIcon },
  { path: '/admin/reviews', label: 'Отзывы', icon: reviewsIcon },
  { path: '/admin/applications', label: 'Заявки', icon: formIcon }
]

onMounted(async () => {
  const session = await getSession()
  if (!session && route.path !== '/admin/login') {
    router.replace('/admin/login')
  }
})

async function handleLogout() {
  await signOut()
  router.replace('/admin/login')
}

function isActive(path) {
  if (path === '/admin') return route.path === '/admin'
  return route.path.startsWith(path)
}
</script>

<template>
  <div class="admin-layout login-mode" v-if="route.path === '/admin/login'">
    <router-view />
  </div>
  <div class="admin-layout" v-else>
    <aside class="sidebar">
      <div class="sidebar-header">
        <router-link to="/" class="sidebar-logo">GREENCODE</router-link>
        <span class="sidebar-label">Admin Panel</span>
      </div>
      <nav class="sidebar-nav">
        <router-link
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          :class="['nav-item', { active: isActive(item.path) }]"
        >
          <img :src="item.icon" alt="" class="nav-icon" loading="lazy" />
          <span class="nav-label">{{ item.label }}</span>
        </router-link>
      </nav>
      <div class="sidebar-footer">
        <router-link to="/" class="site-link">На сайт</router-link>
        <button class="logout-btn" @click="handleLogout">Выйти</button>
      </div>
    </aside>
    <main class="main-area">
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f5f5f5;
}

.admin-layout.login-mode {
  align-items: center;
  justify-content: center;
}

.sidebar {
  width: 240px;
  background: #004524;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.sidebar-header {
  padding: 24px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-logo {
  display: block;
  color: #A8E4A0;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 20px;
  font-weight: 700;
  text-decoration: none;
  letter-spacing: 2px;
}

.sidebar-label {
  display: block;
  color: rgba(255,255,255,0.5);
  font-size: 12px;
  font-family: 'Roboto Mono', monospace;
  margin-top: 4px;
}

.sidebar-nav {
  flex: 1;
  padding: 16px 12px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  border-radius: 12px;
  color: rgba(255,255,255,0.7);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.2s;
}

.nav-item:hover {
  background: rgba(255,255,255,0.08);
  color: white;
}

.nav-item.active {
  background: #44944A;
  color: white;
}

.nav-icon {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  filter: brightness(0) invert(1);
  opacity: 0.7;
}

.nav-item.active .nav-icon {
  opacity: 1;
}

.sidebar-footer {
  padding: 16px 12px;
  border-top: 1px solid rgba(255,255,255,0.1);
}

.site-link {
  display: block;
  text-align: center;
  padding: 10px 16px;
  margin-bottom: 8px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  color: rgba(255,255,255,0.6);
  font-size: 13px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: all 0.2s;
}

.site-link:hover {
  background: rgba(255,255,255,0.08);
  color: white;
}

.logout-btn {
  width: 100%;
  padding: 10px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.2);
  background: transparent;
  color: rgba(255,255,255,0.7);
  font-size: 14px;
  font-family: 'Roboto Mono', monospace;
  cursor: pointer;
  transition: all 0.2s;
}

.logout-btn:hover {
  background: rgba(255,255,255,0.1);
  color: white;
}

.main-area {
  flex: 1;
  padding: 32px;
  overflow-y: auto;
}
</style>
