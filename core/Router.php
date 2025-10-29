<?php
/**
 * Router Class
 * Handles URL routing and dispatching to appropriate controllers
 */

namespace Core;

class Router {
    /**
     * Default controller
     * @var string
     */
    private $defaultController = 'Home';
    
    /**
     * Default action
     * @var string
     */
    private $defaultAction = 'index';
    
    /**
     * Current controller
     * @var string
     */
    private $controller;
    
    /**
     * Current action
     * @var string
     */
    private $action;
    
    /**
     * URL parameters
     * @var array
     */
    private $params = [];
    
    /**
     * Custom routes that map URL patterns to controller actions
     * @var array
     */
    private $customRoutes = [
        'announcements' => ['controller' => 'Announcements', 'action' => 'index'],
        'announcements/view' => ['controller' => 'Announcements', 'action' => 'view'],
        'about/library' => ['controller' => 'Page', 'action' => 'library'],
        'about/librarian' => ['controller' => 'Page', 'action' => 'librarian'],
        'about/staff' => ['controller' => 'Page', 'action' => 'staff'],
        'services' => ['controller' => 'Page', 'action' => 'services'],
        'policies' => ['controller' => 'Page', 'action' => 'policies'],
        'faq' => ['controller' => 'Page', 'action' => 'faq'],
        'contact' => ['controller' => 'Contact', 'action' => 'index'],
        'contact/submit' => ['controller' => 'Contact', 'action' => 'submit'],
        'databases' => ['controller' => 'Resource', 'action' => 'databases'],
        'ebooks' => ['controller' => 'Resources', 'action' => 'ebooks'],
        'ejournals' => ['controller' => 'Resources', 'action' => 'ejournals'],
        // Admin Routes
        // FAQ Routes
        'admin/manage-faqs' => ['controller' => 'Admin', 'action' => 'manageFAQs'],
        'admin/create-faq' => ['controller' => 'Admin', 'action' => 'createFAQ'],
        'admin/update-faq' => ['controller' => 'Admin', 'action' => 'updateFAQ'],
        'admin/delete-faq' => ['controller' => 'Admin', 'action' => 'deleteFAQ'],
        // Database Routes
        'admin/manage-databases' => ['controller' => 'Admin', 'action' => 'manageDatabases'],
        'admin/create-database' => ['controller' => 'Admin', 'action' => 'createDatabase'],
        'admin/edit-database' => ['controller' => 'Admin', 'action' => 'editDatabase'],
        'admin/update-database' => ['controller' => 'Admin', 'action' => 'updateDatabase'],
        'admin/delete-database' => ['controller' => 'Admin', 'action' => 'deleteDatabase'],
        // Announcement Routes
        'admin/manage-announcements' => ['controller' => 'Admin', 'action' => 'manageAnnouncements'],
        'admin/create-announcement' => ['controller' => 'Admin', 'action' => 'createAnnouncement'],
        'admin/update-announcement' => ['controller' => 'Admin', 'action' => 'updateAnnouncement'],
        'admin/delete-announcement' => ['controller' => 'Admin', 'action' => 'deleteAnnouncement'],
        // Policy Routes
        'admin/manage-policies' => ['controller' => 'Admin', 'action' => 'managePolicies'],
        'admin/create-policy' => ['controller' => 'Admin', 'action' => 'createPolicy'],
        'admin/update-policy' => ['controller' => 'Admin', 'action' => 'updatePolicy'],
        'admin/delete-policy' => ['controller' => 'Admin', 'action' => 'deletePolicy'],
        // Service Routes
        'admin/manage-services' => ['controller' => 'Admin', 'action' => 'manageServices'],
        'admin/create-service' => ['controller' => 'Admin', 'action' => 'createService'],
        'admin/update-service' => ['controller' => 'Admin', 'action' => 'updateService'],
        'admin/delete-service' => ['controller' => 'Admin', 'action' => 'deleteService'],
        // Library Information Routes
        'admin/manage-library' => ['controller' => 'Admin', 'action' => 'manageLibrary'],
        'admin/update-library-section' => ['controller' => 'Admin', 'action' => 'updateLibrarySection'],
        // Librarian Profile Routes
        'admin/manage-librarian' => ['controller' => 'Admin', 'action' => 'manageLibrarian'],
        'admin/update-librarian' => ['controller' => 'Admin', 'action' => 'updateLibrarian'],
        // Contact Management Routes
        'admin/manage-contacts' => ['controller' => 'Admin', 'action' => 'manageContacts'],
        'admin/view-contact' => ['controller' => 'Admin', 'action' => 'viewContact'],
        'admin/update-contact-status' => ['controller' => 'Admin', 'action' => 'updateContactStatus'],
        // Carousel Management Routes
        'admin/manage-carousel' => ['controller' => 'Admin', 'action' => 'manageCarousel'],
        'admin/upload-carousel-image' => ['controller' => 'Admin', 'action' => 'uploadCarouselImage'],
        'admin/update-carousel-image' => ['controller' => 'Admin', 'action' => 'updateCarouselImage'],
        'admin/delete-carousel-image' => ['controller' => 'Admin', 'action' => 'deleteCarouselImage'],
        // Library Information Management Routes
        'admin/manage-library-info' => ['controller' => 'Admin', 'action' => 'manageLibraryInfo'],
        'admin/update-library-info' => ['controller' => 'Admin', 'action' => 'updateLibraryInfo'],
        // Account Settings Routes
        'admin/account-settings' => ['controller' => 'Admin', 'action' => 'accountSettings'],
        'admin/update-account-settings' => ['controller' => 'Admin', 'action' => 'updateAccountSettings']
    ];

    /**
     * Static page routes that map to PageController
     * @var array
     */
    private $staticPages = [
        'services' => 'services'
    ];

    public function __construct() {
        $url = $this->parseUrl();
        if (!$url) {
            $this->controller = $this->defaultController . 'Controller';
            $this->action = $this->defaultAction;
            return;
        }

        // Check if it's a POST request to the contact form
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url[0] === 'contact' && isset($url[1]) && $url[1] === 'submit') {
            $this->controller = 'ContactController';
            $this->action = 'submit';
            return;
        }

        // Build the base path for route matching
        $basePath = '';
        $urlCopy = $url;
        $paramStartIndex = 0;

        // Try to match incrementally longer paths
        for ($i = 0; $i < count($urlCopy); $i++) {
            if ($basePath !== '') {
                $basePath .= '/';
            }
            $basePath .= $urlCopy[$i];
            
            if (isset($this->customRoutes[$basePath])) {
                $route = $this->customRoutes[$basePath];
                $this->controller = $route['controller'] . 'Controller';
                $this->action = $route['action'];
                $paramStartIndex = $i + 1;
                break;
            }
        }

        // If no custom route found, use default routing
        if (!isset($route)) {
            if (array_key_exists($url[0], $this->staticPages)) {
                $this->controller = 'PageController';
                $this->action = $this->staticPages[$url[0]];
                array_shift($url);
            } else {
                $this->controller = ucfirst($url[0]) . 'Controller';
                array_shift($url);
                
                $this->action = isset($url[0]) ? $url[0] : $this->defaultAction;
                array_shift($url);
            }
            $this->params = $url;
        } else {
            // For custom routes, collect remaining segments as parameters
            $this->params = array_slice($urlCopy, $paramStartIndex);
        }
    }

    /**
     * Parse the URL into segments
     * @return array
     */
    private function parseUrl(): array {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    /**
     * Dispatch the request to the appropriate controller and action
     * @return void
     */
    public function dispatch(): void {
        // Check if controller exists
        $controllerClass = "\\App\\Controllers\\{$this->controller}";
        if (!class_exists($controllerClass)) {
            $this->handleError(404, "Controller not found: {$this->controller}");
            return;
        }

        // Create controller instance
        $controller = new $controllerClass();

        // Check if action exists
        if (!method_exists($controller, $this->action)) {
            $this->handleError(404, "Action not found: {$this->action}");
            return;
        }

        try {
            // Call the action with parameters
            call_user_func_array([$controller, $this->action], $this->params);
        } catch (\Exception $e) {
            $this->handleError(500, $e->getMessage());
        }
    }

    /**
     * Handle errors by displaying appropriate error page
     * @param int $code HTTP status code
     * @param string $message Error message
     * @return void
     */
    /**
     * Handle errors by displaying appropriate error page
     * @param int $code HTTP status code
     * @param string $message Error message
     * @return void
     */
    private function handleError(int $code, string $message): void {
        http_response_code($code);
        
        $errorFile = APP_PATH . "/views/errors/{$code}.php";
        
        // Pass error details to the view if debugging is enabled
        $error = DISPLAY_ERRORS ? $message : null;
        
        // Set default content type to HTML
        header('Content-Type: text/html; charset=UTF-8');
        
        // Handle AJAX requests differently
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => true,
                'code' => $code,
                'message' => $this->getErrorMessage($code)
            ]);
            return;
        }
        
        // Display error page
        if (file_exists($errorFile)) {
            // Buffer output to prevent header issues
            ob_start();
            require $errorFile;
            $content = ob_get_clean();
            echo $content;
        } else {
            // Fallback error display
            echo "<h1>Error {$code}</h1>";
            if (DISPLAY_ERRORS) {
                echo "<p>{$message}</p>";
            }
        }
    }
    
    /**
     * Get user-friendly error message for status code
     * @param int $code HTTP status code
     * @return string Error message
     */
    private function getErrorMessage(int $code): string {
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable'
        ];
        
        return $messages[$code] ?? 'An error occurred';
    }

    /**
     * Get current controller name
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }

    /**
     * Get current action name
     * @return string
     */
    public function getAction(): string {
        return $this->action;
    }

    /**
     * Get current parameters
     * @return array
     */
    public function getParams(): array {
        return $this->params;
    }
}