<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\Dashboard;

class AdminController extends Controller {
    private $userModel;
    private $dashboardModel;
    private $databaseModel;
    private $announcementModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->dashboardModel = new Dashboard();
        $this->databaseModel = new \App\Models\Database();
        $this->announcementModel = new \App\Models\Announcement();
        
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

    /**
     * Display database management page
     */
    public function manageDatabases() {
        try {
            $databases = $this->databaseModel->getAllDatabases();
            $categories = $this->databaseModel->getAllCategories();

            $data = [
                'pageTitle' => 'Manage Databases - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_databases',
                'layout' => 'admin',
                'databases' => $databases,
                'categories' => $categories,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_databases', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageDatabases(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the databases.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Create a new database entry
     */
    public function createDatabase() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-databases');
                return;
            }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'url' => trim($_POST['url'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'icon_path' => null // Placeholder for future icon upload functionality
            ];

            $this->databaseModel->create($data);
            $this->setFlashMessage('success', 'Database link added successfully.');

        } catch (\InvalidArgumentException $e) {
            // Validation errors
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->createDatabase(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while creating the database entry.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-databases');
    }

    /**
     * Display edit form for a database entry
     */
    public function editDatabase() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new \Exception('No database ID provided');
            }

            // Get database entry
            $database = $this->databaseModel->getDatabaseById($id);
            if (!$database) {
                throw new \Exception('Database not found');
            }

            // Get all categories for the dropdown
            $categories = $this->databaseModel->getAllCategories();

            $data = [
                'pageTitle' => 'Edit Database - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_databases',
                'layout' => 'admin',
                'database' => $database,
                'categories' => $categories,
                'error' => $this->getFlashMessage('error'),
                'success' => $this->getFlashMessage('success')
            ];

            $this->render('admin/edit_database', $data);

        } catch (\Exception $e) {
            error_log("Error in AdminController->editDatabase(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the database entry.');
            header('Location: ' . BASE_URL . '/admin/manage-databases');
        }
    }

    /**
     * Update an existing database entry
     */
    public function updateDatabase() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-databases');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No database ID provided');
            }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'url' => trim($_POST['url'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'icon_path' => null // Placeholder for future icon upload functionality
            ];

            $this->databaseModel->update($id, $data);
            $this->setFlashMessage('success', 'Database link updated successfully.');

        } catch (\InvalidArgumentException $e) {
            // Validation errors
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->updateDatabase(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the database entry.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-databases');
    }

    /**
     * Delete a database entry
     */
    public function deleteDatabase() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No database ID provided');
            }

            // Check if database exists
            $database = $this->databaseModel->getDatabaseById($id);
            if (!$database) {
                throw new \Exception('Database not found');
            }

            // Delete the database
            $this->databaseModel->delete($id);
            $this->setFlashMessage('success', 'Database link deleted successfully.');

        } catch (\Exception $e) {
            error_log("Error in AdminController->deleteDatabase(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while deleting the database entry: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/manage-databases');
    }

    /**
     * Display announcement management page
     */
    public function manageAnnouncements() {
        try {
            $announcements = $this->announcementModel->getAllAnnouncements();

            $data = [
                'pageTitle' => 'Manage Announcements - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_announcements',
                'layout' => 'admin',
                'announcements' => $announcements,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_announcements', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageAnnouncements(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the announcements.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Create a new announcement
     */
    public function createAnnouncement() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-announcements');
                return;
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'date_posted' => $_POST['date_posted'] ?? date('Y-m-d'),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $this->announcementModel->create($data);
            $this->setFlashMessage('success', 'Announcement added successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->createAnnouncement(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while creating the announcement.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-announcements');
    }

    /**
     * Update an existing announcement
     */
    public function updateAnnouncement() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-announcements');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No announcement ID provided');
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'date_posted' => $_POST['date_posted'] ?? date('Y-m-d'),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $this->announcementModel->update($id, $data);
            $this->setFlashMessage('success', 'Announcement updated successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->updateAnnouncement(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the announcement.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-announcements');
    }

    /**
     * Delete an announcement
     */
    public function deleteAnnouncement() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No announcement ID provided');
            }

            // Check if announcement exists
            $announcement = $this->announcementModel->getById($id);
            if (!$announcement) {
                throw new \Exception('Announcement not found');
            }

            // Delete the announcement
            $this->announcementModel->delete($id);
            $this->setFlashMessage('success', 'Announcement deleted successfully.');

        } catch (\Exception $e) {
            error_log("Error in AdminController->deleteAnnouncement(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while deleting the announcement: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/manage-announcements');
    }
}