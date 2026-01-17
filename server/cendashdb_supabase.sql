-- ============================================================================
-- CenDash Database - PostgreSQL/Supabase Migration
-- Converted from MySQL/MariaDB
-- Generated: 2026-01-15
-- ============================================================================

-- ============================================================================
-- NOTES FOR SUPABASE:
-- 1. Run this in the Supabase SQL Editor (supabase.com > Project > SQL Editor)
-- 2. Tables are created in order of dependencies (parent tables first)
-- 3. Uses SERIAL for auto-increment (PostgreSQL standard)
-- 4. TIMESTAMPTZ replaces MySQL TIMESTAMP for timezone-aware timestamps
-- 5. TEXT replaces MEDIUMTEXT (PostgreSQL doesn't distinguish text sizes)
-- 6. All backticks removed, identifiers use standard SQL
-- ============================================================================

-- Drop tables if they exist (in reverse dependency order)
DROP TABLE IF EXISTS vendor_users CASCADE;
DROP TABLE IF EXISTS remark CASCADE;
DROP TABLE IF EXISTS users_orders CASCADE;
DROP TABLE IF EXISTS foods CASCADE;
DROP TABLE IF EXISTS vendor CASCADE;
DROP TABLE IF EXISTS vendor_group CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS admin CASCADE;

-- ============================================================================
-- Table: admin
-- ============================================================================
CREATE TABLE admin (
    adm_id SERIAL PRIMARY KEY,
    username VARCHAR(222) NOT NULL,
    password VARCHAR(222) NOT NULL,
    email VARCHAR(222) NOT NULL,
    code VARCHAR(222) NOT NULL DEFAULT '',
    date TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- ============================================================================
-- Table: vendor_group (categories for vendors)
-- ============================================================================
CREATE TABLE vendor_group (
    c_id SERIAL PRIMARY KEY,
    c_name VARCHAR(222) NOT NULL,
    date TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- ============================================================================
-- Table: vendor
-- ============================================================================
CREATE TABLE vendor (
    rs_id SERIAL PRIMARY KEY,
    c_id INTEGER NOT NULL,
    title VARCHAR(222) NOT NULL,
    email VARCHAR(222) NOT NULL,
    phone VARCHAR(222) NOT NULL,
    o_hr VARCHAR(222) NOT NULL,
    c_hr VARCHAR(222) NOT NULL,
    o_days VARCHAR(222) NOT NULL,
    image TEXT NOT NULL,
    date TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_vendor_category FOREIGN KEY (c_id) REFERENCES vendor_group(c_id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ============================================================================
-- Table: foods
-- ============================================================================
CREATE TABLE foods (
    d_id SERIAL PRIMARY KEY,
    rs_id INTEGER NOT NULL,
    title VARCHAR(222) NOT NULL,
    slogan VARCHAR(222) NOT NULL,
    price NUMERIC(10,2) NOT NULL,
    img VARCHAR(222) NOT NULL,
    CONSTRAINT fk_foods_vendor FOREIGN KEY (rs_id) REFERENCES vendor(rs_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ============================================================================
-- Table: users
-- ============================================================================
CREATE TABLE users (
    u_id SERIAL PRIMARY KEY,
    username VARCHAR(222) NOT NULL,
    f_name VARCHAR(222) NOT NULL,
    l_name VARCHAR(222) NOT NULL,
    email VARCHAR(222) NOT NULL,
    phone VARCHAR(222) NOT NULL,
    password VARCHAR(222) NOT NULL,
    address TEXT NOT NULL DEFAULT '',
    status INTEGER NOT NULL DEFAULT 1,
    date TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- ============================================================================
-- Table: users_orders
-- ============================================================================
CREATE TABLE users_orders (
    o_id SERIAL PRIMARY KEY,
    u_id INTEGER NOT NULL,
    title VARCHAR(222) NOT NULL,
    quantity INTEGER NOT NULL,
    price NUMERIC(10,2) NOT NULL,
    status VARCHAR(222) DEFAULT NULL,
    date TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    order_type VARCHAR(255) DEFAULT NULL,
    vendor_remark TEXT DEFAULT NULL,
    rs_id INTEGER NOT NULL DEFAULT 0
);

-- ============================================================================
-- Table: remark
-- ============================================================================
CREATE TABLE remark (
    id SERIAL PRIMARY KEY,
    frm_id INTEGER NOT NULL,
    status VARCHAR(255) NOT NULL,
    remark TEXT NOT NULL,
    remark_date TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- ============================================================================
-- Table: vendor_users
-- ============================================================================
CREATE TABLE vendor_users (
    vu_id SERIAL PRIMARY KEY,
    username VARCHAR(222) NOT NULL,
    f_name VARCHAR(222) NOT NULL,
    l_name VARCHAR(222) NOT NULL,
    email VARCHAR(222) NOT NULL,
    phone VARCHAR(222) NOT NULL,
    password VARCHAR(222) NOT NULL,
    rs_id INTEGER NOT NULL,
    date TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_vendor_users_restaurant FOREIGN KEY (rs_id) REFERENCES vendor(rs_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ============================================================================
-- Create indexes for better query performance
-- ============================================================================
CREATE INDEX idx_vendor_category ON vendor(c_id);
CREATE INDEX idx_foods_vendor ON foods(rs_id);
CREATE INDEX idx_users_orders_user ON users_orders(u_id);
CREATE INDEX idx_users_orders_vendor ON users_orders(rs_id);
CREATE INDEX idx_remark_order ON remark(frm_id);
CREATE INDEX idx_vendor_users_vendor ON vendor_users(rs_id);

-- ============================================================================
-- SEED DATA
-- ============================================================================

-- Admin (password is MD5 hash of 'admin123')
INSERT INTO admin (adm_id, username, password, email, code, date) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@mail.com', '', '2023-11-30 03:53:02');

-- Vendor Groups (Categories)
INSERT INTO vendor_group (c_id, c_name, date) VALUES
(1, 'Meals', '2023-11-30 10:38:08'),
(2, 'Drinks', '2023-11-30 04:29:33'),
(3, 'Grilled', '2023-11-30 04:06:33'),
(4, 'Fried', '2023-11-30 04:07:30'),
(5, 'Milkshakes', '2023-11-30 04:29:49');

-- Vendors
INSERT INTO vendor (rs_id, c_id, title, email, phone, o_hr, c_hr, o_days, image, date) VALUES
(1, 1, 'Ate Meanns Silog', 'atemeannssilog@gmail.com', '+63123456789', '--Select your Hours--', '3pm', 'mon-sat', '658ba7b9d53ad.jpg', '2023-12-27 04:27:37'),
(2, 1, 'Eymi', 'eymi@gmail.com', '63123456789', '8am', '5pm', 'mon-fri', '6568708c75629.jpg', '2023-11-30 11:22:52'),
(4, 1, 'Caleighas', 'john.olazo@neu.edu.ph', '63123456789', '8am', '8pm', 'mon-fri', '656864b85536f.jpg', '2023-11-30 10:32:24'),
(5, 1, 'Tea Xplode Store', 'teaXplode@gmail.com', '+635532784257', '8am', '8pm', 'Mon-Sat', '656b41e5743ef.jpg', '2023-12-02 14:40:37'),
(6, 1, 'Curbs', 'curbsss@gmai.com', '+637724868290', '8am', '8pm', 'Mon-Fri', '656b428fce220.jpg', '2023-12-02 14:43:27'),
(7, 4, 'Jollibess', 'jollibessi@gmai.com', '+638386029265', '8am', '8pm', 'Mon-Sat', '656b4343b475a.jpg', '2023-12-02 14:46:27');

-- Foods
INSERT INTO foods (d_id, rs_id, title, slogan, price, img) VALUES
(1, 1, 'Porksilog', 'Fried pork chop with fried rice and egg.', 75.00, '65686d09e33a0.jpg'),
(2, 1, 'Hotsilog', 'Hotdog, garlic fried rice, and egg.', 50.00, '65682ca396f1b.png'),
(3, 4, 'Bibimbap Overload', '2x Egg, Meat, and Vegetable', 99.00, '65686b63c5548.jpg'),
(4, 1, 'Shangsilog', 'Shanghai, fried rice, and egg.', 45.00, '65682bf032fe9.jpg'),
(5, 2, 'Beef Shawarma', 'Solo', 69.00, '6568739e9f671.jpeg'),
(6, 2, 'Siomai Rice', '5Pcs with rice + coke float', 65.00, '6568747df3ed2.jpg'),
(17, 7, 'BLT sandwich', 'Special BLT sandwich', 65.00, '656b4462ea896.jpg'),
(18, 6, 'Eggplant Katsu', 'Eggplant Katsu over rice ', 65.00, '656b45b3a6543.jpg'),
(19, 5, 'Dark Nutella', 'Dark choco milk tea', 50.00, '656b464a23903.jpg'),
(20, 5, 'Takoyaki', 'Squid Takoyaki 4pcs', 50.00, '656b46e13e507.jpg');

-- Users
INSERT INTO users (u_id, username, f_name, l_name, email, phone, password, address, status, date) VALUES
(9, 'Sairarat ', 'Sai', 'De Mesa', 'ssdemesa14@gmail.com', '09959866824', '89a6a82de47f9489f699ae1fa0b31ef7', 'Sa heart mo :3', 1, '2023-12-01 08:32:01'),
(21, 'blahblah', 'blahblah', 'blahblah', 'blahblah@gmail.com', '9999999999999', '$2y$10$pceAYkI6VtwOSwmO/J1LTexWoQ433R8OxT2K.wouFNQdw1XyKLgNG', '', 1, '2023-12-21 08:31:09'),
(24, 'raiven', 'raiven', 'raiven', 'raiven@gmail.com', '9999999999999', '3221728385b64ffd93ac5ed2a6ec787b', '', 1, '2024-01-08 10:51:46'),
(25, 'felix', 'felix', 'felix', 'felix@gmail.com', '999999999999999', '25779f8829ab7a7650e85a4cc871e6ac', '', 1, '2023-12-26 09:21:34');

-- User Orders
INSERT INTO users_orders (o_id, u_id, title, quantity, price, status, date, order_type, vendor_remark, rs_id) VALUES
(1, 4, 'Spring Rolls', 2, 6.00, 'rejected', '2022-05-27 11:43:26', NULL, NULL, 0),
(2, 4, 'Prawn Crackers', 1, 7.00, 'closed', '2022-05-27 11:11:41', NULL, NULL, 0),
(3, 5, 'Chicken Madeira', 1, 23.00, 'closed', '2022-05-27 11:42:35', NULL, NULL, 0),
(4, 5, 'Cheesy Mashed Potato', 1, 5.00, 'in process', '2022-05-27 11:42:55', NULL, NULL, 0),
(5, 5, 'Meatballs Penne Pasta', 1, 10.00, 'closed', '2022-05-27 13:18:03', NULL, NULL, 0),
(6, 5, 'Yorkshire Lamb Patties', 1, 14.00, NULL, '2022-05-27 11:40:51', NULL, NULL, 0),
(7, 6, 'Yorkshire Lamb Patties', 1, 14.00, 'closed', '2022-05-27 13:04:33', NULL, NULL, 0),
(8, 6, 'Lobster Thermidor', 1, 36.00, 'closed', '2022-05-27 13:05:24', NULL, NULL, 0),
(9, 6, 'Stuffed Jacket Potatoes', 1, 8.00, 'rejected', '2022-05-27 13:03:53', NULL, NULL, 0),
(23, 8, 'Porksilog', 1, 75.00, 'in process', '2023-12-01 01:27:38', 'Dine In', NULL, 0),
(26, 11, 'Porksilog', 1, 75.00, NULL, '2023-12-01 09:33:29', 'Take Out', NULL, 0),
(27, 11, 'Hotsilog', 1, 50.00, NULL, '2023-12-01 09:33:29', 'Take Out', NULL, 0),
(28, 11, 'Beef Shawarma', 5, 69.00, 'in process', '2023-12-01 09:35:51', 'Take Out', NULL, 0),
(29, 11, 'Siomai Rice', 1, 65.00, NULL, '2023-12-01 09:33:29', 'Take Out', NULL, 0),
(37, 7, 'Porksilog', 1, 75.00, NULL, '2023-12-17 01:06:53', 'Dine In', NULL, 0),
(38, 7, 'Hotsilog', 1, 50.00, NULL, '2023-12-17 01:06:53', 'Dine In', NULL, 0),
(58, 24, 'Eggplant Katsu', 1, 65.00, 'in process', '2024-01-04 13:20:45', 'Dine In', 'OTW', 6),
(62, 24, 'Dark Nutella', 1, 50.00, NULL, '2024-01-06 02:16:13', 'Dine In', NULL, 5),
(67, 24, 'Bibimbap Overload', 1, 99.00, NULL, '2024-01-21 07:32:44', 'Dine In', NULL, 4),
(68, 24, 'Porksilog', 1, 75.00, NULL, '2024-01-21 07:33:10', 'Dine In', NULL, 1),
(69, 24, 'Porksilog', 1, 75.00, NULL, '2024-01-21 14:32:03', 'Dine In', NULL, 1),
(70, 24, 'Porksilog', 1, 75.00, NULL, '2024-01-21 14:33:13', 'Dine In', NULL, 1);

-- Remarks
INSERT INTO remark (id, frm_id, status, remark, remark_date) VALUES
(13, 23, 'in process', 'blahblah', '2023-12-01 01:27:38'),
(14, 28, 'in process', 'Hello, pa wait lang po ng order nyo. Thank you!!', '2023-12-01 09:35:51'),
(15, 30, 'in process', 'Pahintay nalang po, thank you!!', '2023-12-01 10:03:10'),
(16, 31, 'closed', 'THANK YOU PO SA PAGBILI, I LOVE YOU PO SAIRA DE MESA', '2023-12-01 10:04:19'),
(17, 57, 'in process', 'PAANTAY NALANG PO TY', '2023-12-29 08:45:32'),
(18, 57, 'closed', 'THANKS', '2023-12-29 09:07:33'),
(19, 58, 'in process', 'ASDSA', '2024-01-02 16:47:17'),
(20, 58, 'closed', 'asdas', '2024-01-02 16:47:51'),
(21, 58, 'in process', 'OTW', '2024-01-04 13:20:45'),
(22, 59, 'rejected', 's', '2024-01-06 09:52:29');

-- Vendor Users
INSERT INTO vendor_users (vu_id, username, f_name, l_name, email, phone, password, rs_id, date) VALUES
(1, 'raiven', 'raiven', 'raiven', 'raiven@gmail.com', '9999999999999', '3221728385b64ffd93ac5ed2a6ec787b', 1, '2023-12-27 02:50:20');

-- ============================================================================
-- Reset sequences to continue from max ID + 1
-- ============================================================================
SELECT setval('admin_adm_id_seq', (SELECT COALESCE(MAX(adm_id), 0) + 1 FROM admin), false);
SELECT setval('vendor_group_c_id_seq', (SELECT COALESCE(MAX(c_id), 0) + 1 FROM vendor_group), false);
SELECT setval('vendor_rs_id_seq', (SELECT COALESCE(MAX(rs_id), 0) + 1 FROM vendor), false);
SELECT setval('foods_d_id_seq', (SELECT COALESCE(MAX(d_id), 0) + 1 FROM foods), false);
SELECT setval('users_u_id_seq', (SELECT COALESCE(MAX(u_id), 0) + 1 FROM users), false);
SELECT setval('users_orders_o_id_seq', (SELECT COALESCE(MAX(o_id), 0) + 1 FROM users_orders), false);
SELECT setval('remark_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM remark), false);
SELECT setval('vendor_users_vu_id_seq', (SELECT COALESCE(MAX(vu_id), 0) + 1 FROM vendor_users), false);

-- ============================================================================
-- SUPABASE ROW LEVEL SECURITY (RLS) - Optional but Recommended
-- Enable these after you've set up Supabase Auth
-- ============================================================================

-- Enable RLS on all tables (uncomment when ready)
-- ALTER TABLE admin ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE users ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE vendor ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE vendor_group ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE vendor_users ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE foods ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE users_orders ENABLE ROW LEVEL SECURITY;
-- ALTER TABLE remark ENABLE ROW LEVEL SECURITY;

-- Example RLS policies (uncomment and customize as needed)
-- Allow anyone to read foods (menu items)
-- CREATE POLICY "Foods are viewable by everyone" ON foods FOR SELECT USING (true);

-- Allow authenticated users to read vendors
-- CREATE POLICY "Vendors are viewable by everyone" ON vendor FOR SELECT USING (true);

-- Allow users to see only their own orders
-- CREATE POLICY "Users can view own orders" ON users_orders FOR SELECT USING (auth.uid()::text = u_id::text);

-- ============================================================================
-- DONE! Your database is ready for Supabase
-- ============================================================================
