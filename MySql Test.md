# MySQL Coding Challenge

This repository contains a set of MySQL exercises designed to test and enhance your database querying skills. The challenges are based on a sample e-commerce schema.

## 📌 Challenge Overview
The database consists of the following tables:
- **customers**: Stores customer information.
- **products**: Stores product details.
- **orders**: Stores order records.
- **order_items**: Links products with orders.
- **reviews**: Stores product reviews from customers.

The goal is to write optimized queries for common business requirements.

## 📋 Exercises & Solutions

### 1️⃣ Total Sales Revenue by Product
Retrieve the total sales revenue for each product.
```sql
SELECT p.id, p.name, SUM(oi.quantity * oi.price) AS total_revenue
FROM order_items oi
JOIN products p ON oi.product_id = p.id
GROUP BY p.id;
```

### 2️⃣ Top 5 Customers by Spending
Identify the top customers based on their total spending.
```sql
SELECT c.id, c.name, SUM(oi.quantity * oi.price) AS total_spending
FROM customers c
JOIN orders o ON c.id = o.customer_id
JOIN order_items oi ON o.id = oi.order_id
GROUP BY c.id
ORDER BY total_spending DESC
LIMIT 5;
```

### 3️⃣ Average Order Value per Customer
Calculate the average value of orders placed by each customer.
```sql
SELECT c.id, c.name, SUM(oi.quantity * oi.price) / COUNT(DISTINCT o.id) AS avg_order_value
FROM customers c
JOIN orders o ON c.id = o.customer_id
JOIN order_items oi ON o.id = oi.order_id
GROUP BY c.id, c.name
HAVING
    COUNT(DISTINCT o.id) > 0
ORDER BY
    avg_order_value DESC;
```

### 4️⃣ Recent Orders (Last 30 Days)
Fetch orders placed in the last 30 days.
```sql
SELECT o.id AS order_id, c.name AS customer_name, o.order_date, o.status
FROM orders o
JOIN customers c ON o.customer_id = c.id
WHERE o.order_date >= NOW() - INTERVAL 30 DAY
ORDER BY o.order_date DESC;
```

### 5️⃣ Running Total of Customer Spending
Calculate a running total of spending for each customer over time.
```sql
WITH OrderTotals AS (
    SELECT o.customer_id, o.id AS order_id, o.order_date, SUM(oi.quantity * oi.price) AS order_total
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.customer_id, o.id, o.order_date
)
SELECT customer_id, order_id, order_date, order_total,
    SUM(order_total) OVER (PARTITION BY customer_id ORDER BY order_date) AS running_total
FROM OrderTotals
ORDER BY customer_id, order_date;
```

### 6️⃣ Product Review Summary
Get average rating and total review count per product.
```sql
SELECT p.id AS product_id, p.name AS product_name, COALESCE(AVG(r.rating), 0) AS average_rating, COUNT(r.id) AS total_reviews
FROM products p
LEFT JOIN reviews r ON p.id = r.product_id
GROUP BY p.id, p.name
ORDER BY average_rating DESC, total_reviews DESC;
```

### 7️⃣ Customers Without Orders
Find customers who have never placed an order.
```sql
SELECT c.id AS customer_id, c.name AS customer_name
FROM customers c
LEFT JOIN orders o ON c.id = o.customer_id
WHERE o.id IS NULL;
```

### 8️⃣ Update Last Purchased Date
Set the `last_purchased` field for products based on the latest order date.
```sql
UPDATE products p
SET last_purchased = (
    SELECT MAX(o.order_date)
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    WHERE oi.product_id = p.id
)
WHERE EXISTS (
    SELECT 1 FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE oi.product_id = p.id
);
```

### 9️⃣ Transaction Scenario
Insert a new order and update stock in a transaction.
```sql
START TRANSACTION;

-- Step 1: Insert a new order (Assuming customer ID 1 is placing an order)
INSERT INTO orders (customer_id, order_date, status) 
VALUES (1, NOW(), 'completed');

-- Get the last inserted order ID
SET @order_id = LAST_INSERT_ID();

-- Step 2: Insert order items (Assuming customer orders 1 Laptop and 2 Headphones)
INSERT INTO order_items (order_id, product_id, quantity, price)
VALUES 
    (@order_id, 1, 1, (SELECT price FROM products WHERE id = 1)),  -- 1 Laptop
    (@order_id, 3, 2, (SELECT price FROM products WHERE id = 3));  -- 2 Headphones

-- Step 3: Deduct stock for each product
UPDATE products 
SET stock = stock - 1 
WHERE id = 1 AND stock >= 1;  -- Deduct 1 Laptop

UPDATE products 
SET stock = stock - 2 
WHERE id = 3 AND stock >= 2;  -- Deduct 2 Headphones

-- Step 4: Update last_purchased timestamp for the products in the order
UPDATE products 
SET last_purchased = NOW() 
WHERE id IN (1, 3);

-- Step 5: Check if stock deduction was successful
IF ROW_COUNT() = 0 THEN
    ROLLBACK;  -- If no stock update happened (out of stock issue), rollback transaction
ELSE
    COMMIT;  -- If everything is fine, commit the transaction
END IF;
```

### 🔍 Query Optimization & Indexing
Adding indexes to improve query performance.
```sql
-- Index on foreign keys for faster JOIN operations
CREATE INDEX idx_orders_customer_id ON orders(customer_id);
CREATE INDEX idx_order_items_order_id ON order_items(order_id);
CREATE INDEX idx_order_items_product_id ON order_items(product_id);

-- Composite index for sorting and filtering
CREATE INDEX idx_order_items_quantity_price ON order_items(quantity, price);
```

### 🚀 Optimized Query Example
Find total spending per customer efficiently.
```sql
SELECT c.id AS customer_id, c.name, COALESCE(SUM(oi.quantity * oi.price), 0) AS total_spent
FROM customers c
JOIN orders o ON c.id = o.customer_id
JOIN order_items oi ON o.id = oi.order_id
GROUP BY c.id, c.name
ORDER BY total_spent DESC;
```