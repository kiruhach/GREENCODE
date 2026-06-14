-- Create services table
CREATE TABLE services (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  category TEXT NOT NULL,
  icon TEXT,
  sub_items TEXT[],
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now())
);

-- Create service_details table (descriptions for each sub-item)
CREATE TABLE service_details (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  service_id UUID REFERENCES services(id) ON DELETE CASCADE,
  sub_item TEXT NOT NULL,
  description TEXT NOT NULL,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now())
);

-- Enable RLS
ALTER TABLE services ENABLE ROW LEVEL SECURITY;
ALTER TABLE service_details ENABLE ROW LEVEL SECURITY;

-- Public read access
CREATE POLICY "Public read access" ON services FOR SELECT USING (true);
CREATE POLICY "Public read access" ON service_details FOR SELECT USING (true);

-- Enable realtime
ALTER PUBLICATION supabase_realtime ADD TABLE services;
ALTER PUBLICATION supabase_realtime ADD TABLE service_details;

-- Insert services
INSERT INTO services (title, description, category, icon, sub_items, sort_order) VALUES
(
  'Разработка сайтов',
  'Корпоративные сайты, интернет-магазины и Landing Page, где производительность, структура и визуальный стиль работают на результат.',
  'Разработка сайтов',
  'create_site',
  ARRAY['Корпоративные сайты', 'Интернет-магазины', 'Landing Page', 'Техническая оптимизация'],
  1
),
(
  'SEO-продвижение',
  'Делаем SEO частью продукта с первого дня: от аудита до внутренней и внешней оптимизации, включая генеративный поиск.',
  'SEO-продвижение',
  'seo_up',
  ARRAY['SEO-аудит', 'Внутренняя оптимизация', 'Внешняя оптимизация', 'Генеративная оптимизация'],
  2
),
(
  'Веб-дизайн',
  'Проектируем интерфейсы с фокусом на пользовательский сценарий, визуальный ритм и конверсию.',
  'Веб-дизайн',
  'design',
  ARRAY['UI/UX дизайн', 'Прототипирование', 'Дизайн-системы', 'Адаптивные интерфейсы'],
  3
),
(
  'Брендинг',
  'Создаём айдентику, которая делает бизнес узнаваемым и помогает держать единый тон во всех цифровых точках.',
  'Брендинг',
  'branding',
  ARRAY['Смысловая платформа', 'Визуальный код', 'Голос бренда', 'Правила работы со стилем'],
  4
),
(
  'Контент-маркетинг',
  'Помогаем бренду говорить убедительно: через контент-стратегию, SEO-материалы и тексты для воронки продаж.',
  'Контент-маркетинг',
  'content_marketing',
  ARRAY['Контент-стратегия', 'SEO-статьи', 'Тексты для сайта', 'Контент-планы'],
  5
),
(
  'Веб-аналитика',
  'Настраиваем аналитическую основу: дашборды, события, отчёты и контроль за воронкой.',
  'Веб-аналитика',
  'web_analytics',
  ARRAY['Настройка целей и событий', 'Панели показателей', 'Отчётность', 'Метрики улучшения результатов'],
  6
);

-- Insert service_details
INSERT INTO service_details (service_id, sub_item, description, sort_order) VALUES
-- Разработка сайтов (id будет получен через подзапрос)
((SELECT id FROM services WHERE title = 'Разработка сайтов'), 'Корпоративные сайты', 'Полнофункциональные сайты компаний с презентацией услуг, команды, контактов и экспертизы. Включают смысловые страницы, каталог услуг, форму заявки и интеграции.', 1),
((SELECT id FROM services WHERE title = 'Разработка сайтов'), 'Интернет-магазины', 'Полноценные магазины с каталогом товаров, корзиной, оформлением заказов, личным кабинетом и интеграциями с платёжными системами и 1С.', 2),
((SELECT id FROM services WHERE title = 'Разработка сайтов'), 'Landing Page', 'Посадочные страницы для конкретных целей: продажа товара, сбор заявок, регистрация на мероприятие. С фокусом на конверсию.', 3),
((SELECT id FROM services WHERE title = 'Разработка сайтов'), 'Техническая оптимизация', 'Ускорение загрузки, оптимизация кода, настройка кэширования, исправление ошибок и улучшение технических показателей.', 4),

-- SEO-продвижение
((SELECT id FROM services WHERE title = 'SEO-продвижение'), 'SEO-аудит', 'Комплексный анализ сайта: техническое состояние, контент, структура, конкуренты. Выявляем проблемы и возможности роста.', 1),
((SELECT id FROM services WHERE title = 'SEO-продвижение'), 'Внутренняя оптимизация', 'Работа с контентом, структурой, мета-тегами, внутренними ссылками. Настройка ЧПУ, карт сайта, Robots.txt.', 2),
((SELECT id FROM services WHERE title = 'SEO-продвижение'), 'Внешняя оптимизация', 'Наращивание качественной ссылочной массы, работа с репутацией, размещение на тематических площадках.', 3),
((SELECT id FROM services WHERE title = 'SEO-продвижение'), 'Генеративная оптимизация', 'Подготовка сайта к появлению в AI-поиске и голосовых системах. Структурированные данные и оптимизация под LLM.', 4),

-- Веб-дизайн
((SELECT id FROM services WHERE title = 'Веб-дизайн'), 'UI/UX дизайн', 'Проектирование визуально привлекательных и удобных интерфейсов с учётом поведения пользователей и целей бизнеса.', 1),
((SELECT id FROM services WHERE title = 'Веб-дизайн'), 'Прототипирование', 'Создание макетов страниц и интерактивных прототипов для согласования структуры до начала дизайна.', 2),
((SELECT id FROM services WHERE title = 'Веб-дизайн'), 'Дизайн-системы', 'Разработка единой системы компонентов, стилей и правил для масштабирования дизайна на большой проект.', 3),
((SELECT id FROM services WHERE title = 'Веб-дизайн'), 'Адаптивные интерфейсы', 'Вёрстка, корректно работающая на всех устройствах: десктоп, планшет, мобильный телефон.', 4),

-- Брендинг
((SELECT id FROM services WHERE title = 'Брендинг'), 'Смысловая платформа', 'Разработка основных смыслов бренда: миссия, ценности, позиционирование, УТП.', 1),
((SELECT id FROM services WHERE title = 'Брендинг'), 'Визуальный код', 'Создание цветовой палитры, типографики, иконок и графических элементов бренда.', 2),
((SELECT id FROM services WHERE title = 'Брендинг'), 'Голос бренда', 'Определение тона и стиля коммуникации бренда: как говорить с аудиторией.', 3),
((SELECT id FROM services WHERE title = 'Брендинг'), 'Правила работы со стилем', 'Брендбук и гайдлайны по использованию фирменного стиля во всех каналах.', 4),

-- Контент-маркетинг
((SELECT id FROM services WHERE title = 'Контент-маркетинг'), 'Контент-стратегия', 'Планирование контента для достижения бизнес-целей: воронка, типы контента, каналы.', 1),
((SELECT id FROM services WHERE title = 'Контент-маркетинг'), 'SEO-статьи', 'Написание экспертных оптимизированных статей для привлечения органического трафика.', 2),
((SELECT id FROM services WHERE title = 'Контент-маркетинг'), 'Тексты для сайта', 'Создание продающих текстов для главной, страниц услуг, карточек товаров.', 3),
((SELECT id FROM services WHERE title = 'Контент-маркетинг'), 'Контент-планы', 'Редакционный календарь с планированием публикаций по сезонам и целям.', 4),

-- Веб-аналитика
((SELECT id FROM services WHERE title = 'Веб-аналитика'), 'Настройка целей и событий', 'Подключение систем аналитики для отслеживания действий пользователей.', 1),
((SELECT id FROM services WHERE title = 'Веб-аналитика'), 'Панели показателей', 'Визуализация ключевых метрик в удобных дашбордах для принятия решений.', 2),
((SELECT id FROM services WHERE title = 'Веб-аналитика'), 'Отчётность', 'Регулярные отчёты о результатах продвижения и рекомендации по улучшению.', 3),
((SELECT id FROM services WHERE title = 'Веб-аналитика'), 'Метрики улучшения результатов', 'Анализ данных и поиск точек роста для увеличения эффективности.', 4);
