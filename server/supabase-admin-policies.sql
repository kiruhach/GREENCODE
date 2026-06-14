-- RLS policies for admin CRUD operations
-- Run this in Supabase SQL Editor

-- Cases
CREATE POLICY "Authenticated users can insert" ON cases
  FOR INSERT WITH CHECK (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can update" ON cases
  FOR UPDATE USING (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can delete" ON cases
  FOR DELETE USING (auth.role() = 'authenticated');

-- Reviews
CREATE POLICY "Authenticated users can update" ON reviews
  FOR UPDATE USING (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can delete" ON reviews
  FOR DELETE USING (auth.role() = 'authenticated');

-- Applications
CREATE POLICY "Authenticated users can update" ON applications
  FOR UPDATE USING (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can delete" ON applications
  FOR DELETE USING (auth.role() = 'authenticated');

-- Services
CREATE POLICY "Authenticated users can insert" ON services
  FOR INSERT WITH CHECK (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can update" ON services
  FOR UPDATE USING (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can delete" ON services
  FOR DELETE USING (auth.role() = 'authenticated');

-- Service details
CREATE POLICY "Authenticated users can insert" ON service_details
  FOR INSERT WITH CHECK (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can update" ON service_details
  FOR UPDATE USING (auth.role() = 'authenticated');

CREATE POLICY "Authenticated users can delete" ON service_details
  FOR DELETE USING (auth.role() = 'authenticated');
