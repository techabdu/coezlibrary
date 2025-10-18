-- About Section Tables

-- College Information Table
CREATE TABLE college_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    section ENUM('history', 'mission', 'vision', 'overview') NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Librarian Information Table
CREATE TABLE librarian_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    qualification TEXT NOT NULL,
    message TEXT NOT NULL,
    image_path VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    office_hours TEXT,
    social_links JSON,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Staff Members Table
CREATE TABLE staff_members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    department VARCHAR(255),
    qualification TEXT,
    bio TEXT,
    image_path VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    office_hours TEXT,
    joining_date DATE,
    is_active BOOLEAN DEFAULT 1,
    display_order INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data for college_info
INSERT INTO college_info (title, content, section) VALUES
('Our History', 'The College of Engineering Z Library was established in 1985 as a small departmental collection. Over the years, it has grown into a comprehensive engineering library serving over 5,000 students and faculty members.', 'history'),
('Our Mission', 'To foster academic excellence and lifelong learning by providing comprehensive information resources and innovative services to our college community.', 'mission'),
('Our Vision', 'To be the premier engineering library that empowers students and faculty with cutting-edge resources and technology for academic success and innovation.', 'vision'),
('Overview', 'The College of Engineering Z Library serves as the intellectual heart of our campus, offering a blend of traditional library services and cutting-edge digital resources. We strive to create an inclusive, collaborative environment that supports research, learning, and discovery.', 'overview');

-- Insert sample data for librarian_info
INSERT INTO librarian_info (name, title, qualification, message, image_path, email, phone, office_hours, social_links) VALUES
('Dr. Sarah Johnson', 
'Head Librarian', 
'Ph.D. in Library Science\nMasters in Information Technology\nB.Sc. in Computer Science', 
'Welcome to our library! Our mission is to provide you with the best resources and support for your academic journey. We are constantly evolving to meet the changing needs of our academic community.',
'/public/images/staff/head-librarian.jpg',
'sarah.johnson@library.edu',
'(555) 123-4567',
'Monday-Friday: 9:00 AM - 5:00 PM',
'{"linkedin": "linkedin.com/in/sarahjohnson", "twitter": "twitter.com/sjohnson_lib"}');

-- Insert sample data for staff_members
INSERT INTO staff_members (name, position, department, qualification, bio, image_path, email, phone, office_hours, joining_date, display_order) VALUES
('John Smith', 
'Technical Services Librarian', 
'Technical Services',
'Masters in Library Science',
'John manages our digital resources and ensures seamless access to our online collections.',
'/public/images/staff/john-smith.jpg',
'john.smith@library.edu',
'(555) 123-4568',
'Monday-Friday: 8:00 AM - 4:00 PM',
'2018-06-15',
1),

('Maria Garcia', 
'Reference Librarian', 
'Reference Services',
'Masters in Information Science',
'Maria specializes in research assistance and information literacy instruction.',
'/public/images/staff/maria-garcia.jpg',
'maria.garcia@library.edu',
'(555) 123-4569',
'Monday-Friday: 10:00 AM - 6:00 PM',
'2019-03-20',
2),

('David Chen', 
'Digital Resources Specialist', 
'Digital Services',
'Masters in Digital Library Management',
'David maintains our e-resources and provides technical support for digital platforms.',
'/public/images/staff/david-chen.jpg',
'david.chen@library.edu',
'(555) 123-4570',
'Monday-Friday: 9:00 AM - 5:00 PM',
'2020-01-10',
3);