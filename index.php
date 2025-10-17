<?php
/**
 * Front Controller
 * Entry point for all requests
 */

// Define the application environment
define('ENVIRONMENT', getenv('APP_ENV') ?: 'development');

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Define the application start time
define('APP_START', microtime(true));

// Load configuration
require_once __DIR__ . '/config/config.php';

// Autoloader function
spl_autoload_register(function ($className) {
    // Convert namespace separators to directory separators
    $className = str_replace('\\', '/', $className);
    
    // Map namespace prefixes to directories
    $mappings = [
        'Core/' => __DIR__ . '/core/',
        'App/Controllers/' => __DIR__ . '/app/controllers/',
        'App/Models/' => __DIR__ . '/app/models/'
    ];
    
    // Check each mapping
    foreach ($mappings as $prefix => $baseDir) {
        if (strpos($className, $prefix) === 0) {
            $path = $baseDir . substr($className, strlen($prefix)) . '.php';
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    }
});

// Error handler
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Exception handler
set_exception_handler(function ($e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    
    if (DISPLAY_ERRORS) {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        // Log error
        error_log($e->getMessage() . "\n" . $e->getTraceAsString());
        
        // Show generic error page
        if (file_exists(APP_PATH . "/views/errors/{$code}.php")) {
            require_once APP_PATH . "/views/errors/{$code}.php";
        } else {
            require_once APP_PATH . '/views/errors/500.php';
        }
    }
});

try {
    // Initialize Router
    $router = new Core\Router();
    
    // Dispatch the request
    $router->dispatch();
    
} catch (Exception $e) {
    // Handle any unhandled exceptions
    if (DISPLAY_ERRORS) {
        throw $e;
    } else {
        error_log($e->getMessage());
        require_once APP_PATH . '/views/errors/500.php';
    }
}

// Calculate execution time if debugging is enabled
if (DISPLAY_ERRORS) {
    $executionTime = round((microtime(true) - APP_START) * 1000, 2);
    echo "<!-- Execution Time: {$executionTime}ms -->";
}
?>