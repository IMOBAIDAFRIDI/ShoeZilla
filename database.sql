-- Database Schema for ShoeZilla

CREATE DATABASE IF NOT EXISTS shoezilla;
USE shoezilla;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    old_price DECIMAL(10, 2),
    image_url VARCHAR(255),
    category VARCHAR(50) NOT NULL,
    stock INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Data: Admin User (password: 123)
-- Note: Password hash should be generated using password_hash('123', PASSWORD_DEFAULT) in PHP.
-- For this seed, we'll assume a placeholder hash or the user will register first.
-- INSERT INTO users (username, email, password, is_admin) VALUES ('admin', 'admin@shoezilla.com', '$2y$10$YourHashedPasswordHere', TRUE);

-- Seed Data: Products
INSERT INTO products (name, description, price, old_price, image_url, category, stock, is_featured) VALUES
('Nike Air Max 270', 'The Nike Air Max 270 delivers unrivaled comfort.', 150.00, 180.00, 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/05796a5f-b51f-495c-9c94-9635b706c836/air-max-270-mens-shoes-KkLcGR.png', 'Men', 50, TRUE),
('Adidas Ultraboost', 'Experience the energy return of Boost.', 180.00, NULL, 'https://assets.adidas.com/images/w_600,f_auto,q_auto/1a5b481921474dd88806af5200d72f9d_9366/Ultraboost_Light_Shoes_White_HQ6351_01_standard.jpg', 'Men', 30, TRUE),
('Puma Running Shoes', 'Lightweight and durable running shoes.', 90.00, NULL, 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/195337/01/sv01/fnd/IND/fmt/png/Velocity-NITRO-2-Men', 'Joggers', 100, TRUE),
('Nike Air Force 1', 'Classic style, modern comfort.', 100.00, NULL, 'https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/air-force-1-07-mens-shoes-jBrhbr.png', 'Women', 45, TRUE);
