<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\Dashboard;

class AdminController extends Controller {
    private $userModel;
    private $dashboardModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->dashboardModel = new Dashboard();
        
        // Require authentication for all admin routes except login
        $action = $_GET['url'] ?? '';
        if ($action !== 'admin/login' && $action !== 'admin/authenticate') {
            $this->requireAuth();
        }
    }

    /**
     * Display admin login page
     */
    public function login() {
        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            return;
        }

        $data = [
            'pageTitle' => 'Admin Login - ' . SITE_NAME,
            'error' => $this->getFlashMessage('error')
        ];

        $this->renderPartial('admin/login', $data);
    }

    /**
     * Handle login form submission
     */
    public function authenticate() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/login');
                return;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validate inputs
            if (empty($username) || empty($password)) {
                $this->setFlashMessage('error', 'Please enter both username and password.');
                header('Location: ' . BASE_URL . '/admin/login');
                return;
            }

            // Get user from database
            $user = $this->userModel->getUserByUsername($username);
            if (!$user || !$this->userModel->verifyPassword($password, $user['password_hash'])) {
                $this->setFlashMessage('error', 'Invalid username or password.');
                header('Location: ' . BASE_URL . '/admin/login');
                return;
            }

            // Start session and store user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['last_activity'] = time();

            // Redirect to dashboard
            header('Location: ' . BASE_URL . '/admin/dashboard');

        } catch (\Exception $e) {
            error_log("Error in AdminController->authenticate(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred during login.');
            header('Location: ' . BASE_URL . '/admin/login');
        }
    }

    /**
     * Handle logout
     */
    public function logout() {
        // Destroy all session data
        session_destroy();
        
        // Redirect to login page with success message
        $this->setFlashMessage('success', 'You have been successfully logged out.');
        header('Location: ' . BASE_URL . '/admin/login');
    }

    /**
     * Display admin dashboard
     */
    public function dashboard() {
        try {
            // Get dashboard stats
            $stats = $this->dashboardModel->getStats();
            
            // Get recent activity
            $recentActivity = $this->dashboardModel->getRecentActivity(5);

            $data = [
                'pageTitle' => 'Admin Dashboard - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'dashboard',
                'layout' => 'admin',
                'stats' => $stats,
                'recentActivity' => $recentActivity
            ];

            $this->render('admin/dashboard', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->dashboard(): " . $e->getMessage());
            $data = [
                'pageTitle' => 'Admin Dashboard - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'dashboard',
                'layout' => 'admin',
                'stats' => [
                    'announcements' => 0,
                    'pending_contacts' => 0,
                    'ebooks' => 0,
                    'ejournals' => 0,
                    'databases' => 0
                ],
                'recentActivity' => [],
                'error' => 'An error occurred while loading the dashboard.'
            ];
            $this->render('admin/dashboard', $data);
        }
    }

    /**
     * Require authentication middleware
     * @return void
     */
    protected function requireAuth(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->setFlashMessage('error', 'Please log in to access the admin area.');
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }

        // Check session timeout (30 minutes)
        if (time() - $_SESSION['last_activity'] > 1800) {
            session_destroy();
            $this->setFlashMessage('error', 'Your session has expired. Please log in again.');
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }

        // Update last activity time
        $_SESSION['last_activity'] = time();
    }

    /**
     * Set a flash message
     */
    private function setFlashMessage(string $type, string $message): void {
        $_SESSION['flash_' . $type] = $message;
    }

    /**
     * Get and clear a flash message
     */
    private function getFlashMessage(string $type): ?string {
        $message = $_SESSION['flash_' . $type] ?? null;
        unset($_SESSION['flash_' . $type]);
        return $message;
    }
}