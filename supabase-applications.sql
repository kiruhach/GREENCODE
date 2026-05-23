-- Create applications table
CREATE TABLE applications (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  name TEXT NOT NULL,
  email TEXT,
  phone TEXT,
  company TEXT,
  message TEXT,
  task_details TEXT,
  timeframe TEXT,
  budget TEXT,
  contact_format TEXT,
  services TEXT[],
  status TEXT DEFAULT 'new',
  created_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now())
);

-- Allow public insert and read
ALTER TABLE applications ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Public insert access" ON applications FOR INSERT WITH CHECK (true);
CREATE POLICY "Public read access" ON applications FOR SELECT USING (true);

-- Add new columns if table already exists
ALTER TABLE applications ADD COLUMN IF NOT EXISTS task_details TEXT;
ALTER TABLE applications ADD COLUMN IF NOT EXISTS timeframe TEXT;
ALTER TABLE applications ADD COLUMN IF NOT EXISTS budget TEXT;
ALTER TABLE applications ADD COLUMN IF NOT EXISTS contact_format TEXT;