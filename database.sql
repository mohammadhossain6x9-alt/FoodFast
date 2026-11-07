CREATE DATABASE IF NOT EXISTS food_fast CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE food_fast;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 phone VARCHAR(30) NOT NULL,
 password VARCHAR(255) NOT NULL,
 role ENUM('customer','restaurant','admin') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE restaurants (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL UNIQUE,
 name VARCHAR(150) NOT NULL,
 area VARCHAR(120) NOT NULL,
 address VARCHAR(255) NOT NULL,
 description TEXT,
 approved TINYINT(1) NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE foods (
 id INT AUTO_INCREMENT PRIMARY KEY,
 restaurant_id INT NOT NULL,
 name VARCHAR(150) NOT NULL,
 description TEXT,
 price DECIMAL(10,2) NOT NULL,
 available TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);
CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 customer_id INT NOT NULL,
 restaurant_id INT NOT NULL,
 customer_name VARCHAR(100) NOT NULL,
 phone VARCHAR(30) NOT NULL,
 delivery_address TEXT NOT NULL,
 total DECIMAL(10,2) NOT NULL,
 payment_method VARCHAR(30) NOT NULL DEFAULT 'Cash on delivery',
 status ENUM('Pending','Accepted','Preparing','On the way','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(customer_id) REFERENCES users(id),
 FOREIGN KEY(restaurant_id) REFERENCES restaurants(id)
);
CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 food_id INT NOT NULL,
 food_name VARCHAR(150) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 quantity INT NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY(food_id) REFERENCES foods(id)
);

-- Demo admin account is created securely using setup_admin.php.
