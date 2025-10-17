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
     * Parse the URL and set controller, action and parameters
     */
    public function __construct() {
        $url = $this->parseUrl();
        
        // Set controller
        $this->controller = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : $this->defaultController . 'Controller';
        array_shift($url);
        
        // Set action
        $this->action = isset($url[0]) ? $url[0] : $this->defaultAction;
        array_shift($url);
        
        // Set parameters
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
        $controllerClass = "App\\Controllers\\{$this->controller}";
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