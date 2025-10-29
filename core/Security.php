<?php
namespace Core;

/**
 * Security Class
 * Handles security-related functionality like CSRF protection, input sanitization, etc.
 */
class Security {
    /**
     * Generate a new CSRF token and store it in the session
     * @return string The generated token
     */
    public static function generateCSRFToken(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = [];
        }
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'][$token] = time();
        
        // Clean up old tokens (older than 2 hours)
        foreach ($_SESSION['csrf_tokens'] as $t => $time) {
            if ($time < time() - 7200) {
                unset($_SESSION['csrf_tokens'][$t]);
            }
        }
        
        return $token;
    }
    
    /**
     * Verify a CSRF token
     * @param string $token The token to verify
     * @return bool Whether the token is valid
     */
    public static function verifyCSRFToken(?string $token): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!$token || !isset($_SESSION['csrf_tokens'][$token])) {
            return false;
        }
        
        // Token used, remove it (one-time use)
        unset($_SESSION['csrf_tokens'][$token]);
        return true;
    }
    
    /**
     * Sanitize user input
     * @param mixed $input The input to sanitize
     * @return mixed The sanitized input
     */
    public static function sanitize($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate file upload
     * @param array $file The $_FILES array element
     * @param array $allowedTypes Array of allowed MIME types
     * @param int $maxSize Maximum file size in bytes
     * @return array [bool $isValid, string $error]
     */
    public static function validateFileUpload(array $file, array $allowedTypes, int $maxSize): array {
        if (!isset($file['error']) || is_array($file['error'])) {
            return [false, 'Invalid file parameters'];
        }
        
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return [false, 'File too large'];
            case UPLOAD_ERR_PARTIAL:
                return [false, 'File upload was incomplete'];
            case UPLOAD_ERR_NO_FILE:
                return [false, 'No file was uploaded'];
            default:
                return [false, 'Unknown error occurred'];
        }
        
        if ($file['size'] > $maxSize) {
            return [false, 'File too large'];
        }
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            return [false, 'Invalid file type'];
        }
        
        return [true, ''];
    }
    
    /**
     * Set secure session parameters
     * @return void
     */
    public static function secureSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            $options = [
                'cookie_httponly' => true,     // Prevent JavaScript access
                'cookie_secure' => !empty($_SERVER['HTTPS']), // Require HTTPS
                'use_strict_mode' => true,     // Prevent session fixation
                'cookie_samesite' => 'Lax'     // Prevent CSRF
            ];
            
            session_start($options);
        }
    }
    
    /**
     * Rate limiting check
     * @param string $key Identifier for the rate limit (e.g., 'contact_form_' . $_SERVER['REMOTE_ADDR'])
     * @param int $maxAttempts Maximum number of attempts allowed
     * @param int $timeWindow Time window in seconds
     * @return bool True if within limit, false if exceeded
     */
    public static function checkRateLimit(string $key, int $maxAttempts, int $timeWindow): bool {
        if (!isset($_SESSION['rate_limits'][$key])) {
            $_SESSION['rate_limits'][$key] = [
                'attempts' => 0,
                'window_start' => time()
            ];
        }
        
        $limit = &$_SESSION['rate_limits'][$key];
        
        // Reset window if expired
        if (time() - $limit['window_start'] > $timeWindow) {
            $limit['attempts'] = 0;
            $limit['window_start'] = time();
        }
        
        // Check if limit exceeded
        if ($limit['attempts'] >= $maxAttempts) {
            return false;
        }
        
        $limit['attempts']++;
        return true;
    }
}