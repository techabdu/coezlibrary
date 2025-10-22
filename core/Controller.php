<?php
/**
 * Base Controller Class
 * Handles common controller operations and view rendering
 */

namespace Core;

class Controller {
    /**
     * Reference to the current user (if authenticated)
     * @var array|null
     */
    protected $user = null;
    
    /**
     * Data to be passed to views
     * @var array
     */
    protected $viewData = [];

    /**
     * Constructor
     * Initializes session if not already started
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'name' => SESSION_NAME,
                'cookie_lifetime' => SESSION_LIFETIME,
                'cookie_path' => SESSION_PATH,
                'cookie_secure' => SESSION_SECURE,
                'cookie_httponly' => SESSION_HTTPONLY
            ]);
        }

        // Set current user if authenticated
        if (isset($_SESSION['user_id'])) {
            // TODO: Load user data from database
            $this->user = null;
        }
    }

    /**
     * Render a view file with optional data
     * @param string $view View file path relative to views directory
     * @param array $data Data to be passed to the view
     * @return void
     */
    protected function render(string $view, array $data = []): void {
        // Merge with any existing view data
        $this->viewData = array_merge($this->viewData, $data);
        
        // Extract data to make it available in view
        extract($this->viewData);
        
        // Start output buffering
        ob_start();
        
        // Determine which layout to use
        $layout = $this->viewData['layout'] ?? 'default';
        $layoutPath = $layout === 'admin' ? '/views/layouts/admin' : '/views/layouts';
        
        // Include header
        require_once APP_PATH . $layoutPath . '/header.php';
        
        // Include sidebar for admin layout
        if ($layout === 'admin') {
            require_once APP_PATH . '/views/layouts/admin/sidebar.php';
        }
        
        // Include the view file
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }
        require_once $viewFile;
        
        // Include footer
        require_once APP_PATH . $layoutPath . '/footer.php';
        
        // Flush the output buffer
        ob_end_flush();
    }

    /**
     * Render a view without layout
     * @param string $view View file path relative to views directory
     * @param array $data Data to be passed to the view
     * @return void
     */
    protected function renderPartial(string $view, array $data = []): void {
        extract(array_merge($this->viewData, $data));
        
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }
        require_once $viewFile;
    }

    /**
     * Set a flash message
     * @param string $type success|error|warning|info
     * @param string $message
     * @return void
     */
    protected function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Get and clear flash message
     * @return array|null
     */
    protected function getFlash(): ?array {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Redirect to another URL
     * @param string $url
     * @return void
     */
    protected function redirect(string $url): void {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Check if user is authenticated
     * @return bool
     */
    protected function isAuthenticated(): bool {
        return isset($_SESSION['user_id']);
    }

    /**
     * Require authentication to access a page
     * @return void
     */
    protected function requireAuth(): void {
        if (!$this->isAuthenticated()) {
            $this->setFlash('error', 'Please login to access this page');
            $this->redirect('/admin/login');
        }
    }

    /**
     * Generate CSRF token
     * @return string
     */
    protected function generateCsrfToken(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token
     * @param string $token
     * @return bool
     */
    protected function verifyCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}