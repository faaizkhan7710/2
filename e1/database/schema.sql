-- FoodShare Pakistan Database Schema

CREATE DATABASE IF NOT EXISTS foodshare_pakistan;
USE foodshare_pakistan;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('donor', 'ngo', 'volunteer', 'admin') NOT NULL,
    address TEXT,
    profile_image VARCHAR(255) DEFAULT 'default_profile.png',
    points INT DEFAULT 0,
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Donations Table
CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    quantity VARCHAR(100),
    description TEXT,
    pickup_address TEXT,
    preparation_time DATETIME,
    expiry_time DATETIME,
    image VARCHAR(255),
    status ENUM('available', 'requested', 'accepted', 'picked_up', 'delivered') DEFAULT 'available',
    freshness_score INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Requests Table
CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donation_id INT NOT NULL,
    ngo_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected', 'completed') DEFAULT 'pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donation_id) REFERENCES donations(id) ON DELETE CASCADE,
    FOREIGN KEY (ngo_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Deliveries Table
CREATE TABLE IF NOT EXISTS deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donation_id INT NOT NULL,
    volunteer_id INT,
    pickup_time DATETIME,
    delivery_time DATETIME,
    status ENUM('assigned', 'picked_up', 'delivered') DEFAULT 'assigned',
    FOREIGN KEY (donation_id) REFERENCES donations(id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Impact Statistics Table
CREATE TABLE IF NOT EXISTS impact_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    meals_saved INT DEFAULT 0,
    food_saved_kg DECIMAL(10,2) DEFAULT 0,
    families_helped INT DEFAULT 0,
    co2_reduced DECIMAL(10,2) DEFAULT 0,
    water_saved DECIMAL(10,2) DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Initial Impact Data
INSERT INTO impact_stats (meals_saved, food_saved_kg, families_helped, co2_reduced, water_saved) 
VALUES (1250, 450.5, 320, 1125.2, 5000.0)
ON DUPLICATE KEY UPDATE id=id;
