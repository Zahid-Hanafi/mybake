ALTER TABLE products ADD COLUMN cost_price DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER price;
UPDATE products SET cost_price = price * 0.5;

ALTER TABLE order_items ADD COLUMN cost_price DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER unit_price;
ALTER TABLE offline_sale_items ADD COLUMN cost_price DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER unit_price;
