-- ============================================================================
-- Supabase Security Fixes
-- Run this in the Supabase SQL Editor (supabase.com > Project > SQL Editor)
-- ============================================================================

-- 1. Enable Row Level Security (RLS) on all tables to prevent public access via API
ALTER TABLE admin ENABLE ROW LEVEL SECURITY;
ALTER TABLE foods ENABLE ROW LEVEL SECURITY;
ALTER TABLE remark ENABLE ROW LEVEL SECURITY;
ALTER TABLE users_orders ENABLE ROW LEVEL SECURITY;
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE vendor_group ENABLE ROW LEVEL SECURITY;
ALTER TABLE vendor_users ENABLE ROW LEVEL SECURITY;
ALTER TABLE vendor ENABLE ROW LEVEL SECURITY;

-- 2. Revoke permissions from 'anon' and 'authenticated' roles for sensitive tables
-- This ensures that sensitive columns (like passwords) are not exposed via the API.
REVOKE ALL ON TABLE admin FROM anon, authenticated;
REVOKE ALL ON TABLE users FROM anon, authenticated;
REVOKE ALL ON TABLE vendor_users FROM anon, authenticated;

-- 3. Drop unused index (as reported by Supabase)
DROP INDEX IF EXISTS idx_remark_order;

-- ============================================================================
-- NOTES:
-- Enabling RLS restricts access via the Supabase API (PostgREST).
-- Your PHP application (connecting via standard connection string) usually connects
-- as the 'postgres' user, which bypasses RLS, so the app will continue to work.
-- If you intend to use the Supabase API (JS Client) in the future, you will need
-- to create specific policies (GRANT ... TO anon/authenticated + CREATE POLICY).
-- ============================================================================
