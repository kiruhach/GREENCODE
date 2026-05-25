<script setup>
import logoIcon from '@/assets/icons/logo.svg?url'
import telegramIcon from '@/assets/icons/Telegram.svg?url'
import vkIcon from '@/assets/icons/VK.svg?url'
</script>

<template>
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-grid">
        <!-- Logo & Copyright -->
        <div class="footer-logo">
          <img :src="logoIcon" alt="Greencode" class="footer-logo-img" width="120" height="28" />
          <span class="logo-copyright">© 2026</span>
        </div>

        <!-- Company Links -->
        <div class="footer-links">
          <h4 class="footer-title">Компания</h4>
          <ul class="footer-list">
            <li><router-link to="/services" class="footer-link">Услуги</router-link></li>
            <li><router-link to="/cases" class="footer-link">Кейсы</router-link></li>
            <li><router-link to="/about" class="footer-link">О нас</router-link></li>
          </ul>
        </div>

        <!-- Contacts -->
        <div class="footer-contacts">
          <h4 class="footer-title">Контакты</h4>
          <ul class="footer-list">
            <li><a href="mailto:hello@greencode.studio" class="footer-link">hello@greencode.studio</a></li>
            <li><a href="tel:+79991234567" class="footer-link">+7 (999) 123-45-67</a></li>
          </ul>
        </div>

        <!-- Description & Social -->
        <div class="footer-social">
          <p class="footer-desc">Digital-агентство полного цикла. Создаём сайты, которые работают на ваш бизнес.</p>
          <div class="social-links">
            <a href="#" class="social-icon">
              <img :src="telegramIcon" alt="Telegram" class="social-svg" />
            </a>
            <a href="#" class="social-icon">
              <img :src="vkIcon" alt="VK" class="social-svg" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  background-color: #004524;
  box-shadow: 0px 0px 34px rgba(0, 255, 102, 0.10);
  margin: 80px 16px 0 16px;
  border-radius: 28px 28px 0 0;
  outline: 1px solid rgba(68, 148, 74, 0.2);
  outline-offset: -1px;
  position: relative;
  z-index: 10;
}

.footer-inner {
  max-width: 1920px;
  margin: 0 auto;
  padding: 48px 24px;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 32px;
}

@media (min-width: 1024px) {
  .footer-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.footer-logo {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 12px;
}

.footer-logo-img {
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

.logo-copyright {
  color: rgba(255, 255, 255, 0.56);
  font-size: 14px;
  font-family: 'Space Grotesk', sans-serif;
}

.footer-links, .footer-contacts {
  display: flex;
  flex-direction: column;
}

.footer-title {
  color: white;
  font-size: 20px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 16px;
}

.footer-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer-link {
  color: rgba(255, 255, 255, 0.45);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  text-decoration: none;
  transition: color 0.3s;
}

.footer-link:hover {
  color: rgba(255, 255, 255, 0.7);
}

.footer-social {
  text-align: left;
}

@media (min-width: 1024px) {
  .footer-social {
    text-align: right;
  }
}

.footer-desc {
  color: rgba(255, 255, 255, 0.45);
  font-size: 18px;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 16px;
}

.social-links {
  display: flex;
  gap: 16px;
}

@media (min-width: 1024px) {
  .social-links {
    justify-content: flex-end;
  }
}

.social-icon {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity 0.3s;
}

.social-icon:hover {
  opacity: 0.8;
}

.social-svg {
  width: 28px;
  height: 28px;
  object-fit: contain;
}
</style>