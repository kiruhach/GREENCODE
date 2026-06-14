import { createRouter, createWebHistory } from 'vue-router'
import MainPage from '../components/pages/MainPage.vue'
import ServicesPage from '../components/pages/ServicesPage.vue'
import CasesPage from '../components/pages/CasesPage.vue'
import CaseDetailPage from '../components/pages/CaseDetailPage.vue'
import AboutPage from '../components/pages/AboutPage.vue'
import ContactsPage from '../components/pages/ContactsPage.vue'
import ApplicationPage from '../components/pages/ApplicationPage.vue'
import ReviewsPage from '../components/pages/ReviewsPage.vue'
import AdminLayout from '../components/admin/AdminLayout.vue'
import AdminLogin from '../components/admin/AdminLogin.vue'
import AdminDashboard from '../components/admin/AdminDashboard.vue'
import AdminCases from '../components/admin/AdminCases.vue'
import AdminCaseForm from '../components/admin/AdminCaseForm.vue'
import AdminServices from '../components/admin/AdminServices.vue'
import AdminServiceForm from '../components/admin/AdminServiceForm.vue'
import AdminReviews from '../components/admin/AdminReviews.vue'
import AdminReviewForm from '../components/admin/AdminReviewForm.vue'
import AdminApplications from '../components/admin/AdminApplications.vue'

const routes = [
  {
    path: '/',
    name: 'Main',
    component: MainPage,
    meta: {
      title: 'GREENCODE — Digital-агентство полного цикла',
      description: 'Создаём сайты, которые работают на ваш бизнес. Полный цикл: от стратегии и дизайна до разработки, SEO и аналитики.',
      h1: 'GREENCODE'
    }
  },
  {
    path: '/services',
    name: 'Services',
    component: ServicesPage,
    meta: {
      title: 'Услуги — GREENCODE',
      description: 'Разработка сайтов, SEO-продвижение, веб-дизайн, брендинг, контент-маркетинг и веб-аналитика. Услуги, собранные в одну систему роста.',
      h1: 'Услуги, собранные в одну систему роста'
    }
  },
  {
    path: '/cases',
    name: 'Cases',
    component: CasesPage,
    meta: {
      title: 'Кейсы — GREENCODE',
      description: 'Кейсы, где рост видно в цифрах. Реальные проекты с измеримыми результатами.',
      h1: 'Кейсы, где рост видно в цифрах'
    }
  },
  {
    path: '/cases/:id',
    name: 'CaseDetail',
    component: CaseDetailPage,
    meta: {
      title: 'Кейс — GREENCODE',
      description: 'Подробности кейса',
      h1: 'Кейс'
    }
  },
  {
    path: '/about',
    name: 'About',
    component: AboutPage,
    meta: {
      title: 'О нас — GREENCODE',
      description: 'Команда, которая превращает цифровой хаос в систему роста. Маленькая сильная команда полного цикла.',
      h1: 'О нас — команде, которая превращает цифровой хаос в систему роста'
    }
  },
  {
    path: '/contacts',
    name: 'Contacts',
    component: ContactsPage,
    meta: {
      title: 'Контакты — GREENCODE',
      description: 'Контакты и удобный путь до заявки. Свяжитесь с нами любым удобным способом.',
      h1: 'Контакты и удобный путь до заявки'
    }
  },
  {
    path: '/application',
    name: 'Application',
    component: ApplicationPage,
    meta: {
      title: 'Оставить заявку — GREENCODE',
      description: 'Оставить заявку и быстро запустить следующий шаг. Помогаем сформулировать задачу, даже если бриф ещё сырой.',
      h1: 'Оставить заявку и быстро запустить следующий шаг'
    }
  },
  {
    path: '/reviews',
    name: 'Reviews',
    component: ReviewsPage,
    meta: {
      title: 'Отзывы клиентов — GREENCODE',
      description: 'Отзывы клиентов о совместной работе и результатах. Мнения партнёров о команде GREENCODE.',
      h1: 'Отзывы клиентов'
    }
  },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      {
        path: '',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: { title: 'Дашборд — GREENCODE Admin' }
      },
      {
        path: 'login',
        name: 'AdminLogin',
        component: AdminLogin,
        meta: { title: 'Вход — GREENCODE Admin' }
      },
      {
        path: 'cases',
        name: 'AdminCases',
        component: AdminCases,
        meta: { title: 'Кейсы — GREENCODE Admin' }
      },
      {
        path: 'cases/new',
        name: 'AdminCaseNew',
        component: AdminCaseForm,
        meta: { title: 'Новый кейс — GREENCODE Admin' }
      },
      {
        path: 'cases/:id/edit',
        name: 'AdminCaseEdit',
        component: AdminCaseForm,
        meta: { title: 'Редактировать кейс — GREENCODE Admin' }
      },
      {
        path: 'services',
        name: 'AdminServices',
        component: AdminServices,
        meta: { title: 'Услуги — GREENCODE Admin' }
      },
      {
        path: 'services/new',
        name: 'AdminServiceNew',
        component: AdminServiceForm,
        meta: { title: 'Новая услуга — GREENCODE Admin' }
      },
      {
        path: 'services/:id/edit',
        name: 'AdminServiceEdit',
        component: AdminServiceForm,
        meta: { title: 'Редактировать услугу — GREENCODE Admin' }
      },
      {
        path: 'reviews',
        name: 'AdminReviews',
        component: AdminReviews,
        meta: { title: 'Отзывы — GREENCODE Admin' }
      },
      {
        path: 'reviews/new',
        name: 'AdminReviewNew',
        component: AdminReviewForm,
        meta: { title: 'Новый отзыв — GREENCODE Admin' }
      },
      {
        path: 'reviews/:id/edit',
        name: 'AdminReviewEdit',
        component: AdminReviewForm,
        meta: { title: 'Редактировать отзыв — GREENCODE Admin' }
      },
      {
        path: 'applications',
        name: 'AdminApplications',
        component: AdminApplications,
        meta: { title: 'Заявки — GREENCODE Admin' }
      }
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../components/pages/NotFoundPage.vue'),
    meta: {
      title: '404 — Страница не найдена — GREENCODE',
      description: 'Страница не найдена. Вернитесь на главную или свяжитесь с нами.',
      h1: '404 — Страница не найдена'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = to.meta.title
  }
  next()
})

export default router