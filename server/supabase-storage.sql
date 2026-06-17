-- Создание Storage bucket для изображений кейсов
-- Запусти этот скрипт в SQL Editor Supabase Dashboard

INSERT INTO storage.buckets (id, name, public, file_size_limit, allowed_mime_types)
VALUES (
  'case-images',
  'case-images',
  true,
  5242880,
  ARRAY['image/png', 'image/jpeg', 'image/webp', 'image/gif']
);

-- Разрешить публичное чтение
CREATE POLICY "Public read" ON storage.objects
  FOR SELECT USING (bucket_id = 'case-images');

-- Разрешить админам (авторизованным пользователям) загружать файлы
CREATE POLICY "Admin insert" ON storage.objects
  FOR INSERT WITH CHECK (
    bucket_id = 'case-images'
    AND auth.role() = 'authenticated'
  );

-- Разрешить админам удалять файлы
CREATE POLICY "Admin delete" ON storage.objects
  FOR DELETE USING (
    bucket_id = 'case-images'
    AND auth.role() = 'authenticated'
  );

-- Разрешить админам обновлять файлы
CREATE POLICY "Admin update" ON storage.objects
  FOR UPDATE USING (
    bucket_id = 'case-images'
    AND auth.role() = 'authenticated'
  );
