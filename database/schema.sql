-- Use library_db database
USE library_db;

-- 1. announcements
CREATE TABLE announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_posted DATE NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. external_databases (external links)
CREATE TABLE external_databases (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    url VARCHAR(500) NOT NULL,
    category VARCHAR(100),
    icon_path VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. digital_resources (e-books and e-journals)
CREATE TABLE digital_resources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    category ENUM('ebook', 'ejournal') NOT NULL,
    file_path VARCHAR(500),
    thumbnail_path VARCHAR(255),
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    downloads_count INT DEFAULT 0
);

-- 4. static_pages
CREATE TABLE static_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 5. carousel_images
CREATE TABLE carousel_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1
);

-- 6. faq
CREATE TABLE faq (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(100),
    display_order INT DEFAULT 0
);

-- 7. contact_submissions (Ask a Librarian)
CREATE TABLE contact_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'responded', 'archived') DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. library_info (singleton table)
CREATE TABLE library_info (
    id INT PRIMARY KEY DEFAULT 1,
    hours TEXT,
    location VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(255),
    address TEXT
);

-- 9. users (admin authentication)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'librarian') DEFAULT 'librarian',
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial library info
INSERT INTO library_info (id, hours, location, phone, email, address) VALUES 
(1, 
'Monday-Friday: 8:00 AM - 9:00 PM
Saturday: 9:00 AM - 5:00 PM
Sunday: Closed', 
'Main Campus, Building A, Floor 2',
'+1-234-567-8900',
'library@college.edu',
'123 College Street, Education City, ST 12345');

-- Insert initial admin user (password: 'admin123' - hashed)
INSERT INTO users (username, password_hash, role, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'admin@college.edu');