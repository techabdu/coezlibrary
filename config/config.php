<?php
/**
 * General Application Configuration
 */

// Base URL - Update this according to your environment
define('BASE_URL', 'http://localhost/coezlibrary');

// Site Information
define('SITE_NAME', 'College Library');
define('SITE_DESCRIPTION', 'Library Management System');
define('ADMIN_EMAIL', 'admin@college.edu');

// Directory Paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CORE_PATH', ROOT_PATH . '/core');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Upload Paths
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');
define('EBOOKS_PATH', UPLOADS_PATH . '/ebooks');
define('EJOURNALS_PATH', UPLOADS_PATH . '/ejournals');
define('THUMBNAILS_PATH', UPLOADS_PATH . '/thumbnails');
define('CAROUSEL_PATH', PUBLIC_PATH . '/images/carousel');

// File Upload Limits
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'epub']);
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Session Configuration
define('SESSION_NAME', 'library_session');
define('SESSION_LIFETIME', 7200); // 2 hours in seconds
define('SESSION_PATH', '/');
define('SESSION_SECURE', false); // Set to true in production with HTTPS
define('SESSION_HTTPONLY', true);

// Error Reporting
define('DISPLAY_ERRORS', true); // Set to false in production
error_reporting(E_ALL);
ini_set('display_errors', DISPLAY_ERRORS);

// Time Zone
date_default_timezone_set('UTC');

// Pagination
define('ITEMS_PER_PAGE', 10);

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 8);

// Cache Configuration
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // 1 hour in seconds

// Email Configuration
define('SMTP_HOST', 'smtp.college.edu');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'library@college.edu');
define('SMTP_PASSWORD', ''); // Set in production
define('SMTP_ENCRYPTION', 'tls');