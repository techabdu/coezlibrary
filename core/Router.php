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
        'about/library' => ['controller' => 'Page', 'action' => 'library'],
        'about/librarian' => ['controller' => 'Page', 'action' => 'librarian'],
        'about/staff' => ['controller' => 'Page', 'action' => 'staff'],
        'services' => ['controller' => 'Page', 'action' => 'services']
    ];

    /**
     * Static page routes that map to PageController
     * @var array
     */
    private $staticPages = [
        'services' => 'services',
        'policies' => 'policies'
    ];

    public function __construct() {
        $url = $this->parseUrl();
        $path = is_array($url) ? implode('/', $url) : '';

        // Check custom routes first
        if (!empty($path) && isset($this->customRoutes[$path])) {
            $route = $this->customRoutes[$path];
            $this->controller = $route['controller'] . 'Controller';
            $this->action = $route['action'];
            $this->params = [];
            return;
        }
        
        // Check if this is a static page route
        if (isset($url[0]) && array_key_exists($url[0], $this->staticPages)) {
            $this->controller = 'PageController';
            $this->action = $this->staticPages[$url[0]];
            array_shift($url);
            $this->params = $url;
            return;
        }
        
        // Default routing
        $this->controller = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : $this->defaultController . 'Controller';
        array_shift($url);
        
        $this->action = isset($url[0]) ? $url[0] : $this->defaultAction;
        array_shift($url);
        
        $this->params = $url ?? [];
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
    private function handleError(int $code, string $message): void {
        http_response_code($code);
        
        if (file_exists(APP_PATH . "/views/errors/{$code}.php")) {
            require_once APP_PATH . "/views/errors/{$code}.php";
        } else {
            echo "<h1>Error {$code}</h1>";
            if (DISPLAY_ERRORS) {
                echo "<p>{$message}</p>";
            }
        }
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