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
    private $policyModel;
    private $serviceModel;
    private $faqModel;
    private $contactModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->dashboardModel = new Dashboard();
        $this->databaseModel = new \App\Models\Database();
        $this->announcementModel = new \App\Models\Announcement();
        $this->policyModel = new \App\Models\Policy();
        $this->serviceModel = new \App\Models\Service();
        $this->faqModel = new \App\Models\FAQ();
        $this->contactModel = new \App\Models\Contact();
        
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

    /**
     * Display policies management page
     */
    public function managePolicies() {
        try {
            $policies = $this->policyModel->getAllPolicies();
            $categories = $this->policyModel->getAllCategories();

            $data = [
                'pageTitle' => 'Manage Policies - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_policies',
                'layout' => 'admin',
                'policies' => $policies,
                'categories' => $categories,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_policies', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->managePolicies(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the policies.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Create a new policy
     */
    public function createPolicy() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-policies');
                return;
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $policyModel = new \App\Models\Policy();
            $policyModel->create($data);
            $this->setFlashMessage('success', 'Policy added successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->createPolicy(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while creating the policy.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-policies');
    }

    /**
     * Update an existing policy
     */
    public function updatePolicy() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-policies');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No policy ID provided');
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $policyModel = new \App\Models\Policy();
            $policyModel->update($id, $data);
            $this->setFlashMessage('success', 'Policy updated successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->updatePolicy(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the policy.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-policies');
    }

    /**
     * Delete a policy
     */
    public function deletePolicy() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No policy ID provided');
            }

            // Check if policy exists
            $policyModel = new \App\Models\Policy();
            $policy = $policyModel->getPolicyById($id);
            if (!$policy) {
                throw new \Exception('Policy not found');
            }

            // Delete the policy
            $policyModel->delete($id);
            $this->setFlashMessage('success', 'Policy deleted successfully.');

        } catch (\Exception $e) {
            error_log("Error in AdminController->deletePolicy(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while deleting the policy: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/manage-policies');
    }

    /**
     * Display services management page
     */
    public function manageServices() {
        try {
            $services = $this->serviceModel->getAllServices();

            $data = [
                'pageTitle' => 'Manage Services - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_services',
                'layout' => 'admin',
                'services' => $services,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_services', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageServices(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the services.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Create a new service
     */
    public function createService() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-services');
                return;
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'icon_class' => trim($_POST['icon_class'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $this->serviceModel->createService($data);
            $this->setFlashMessage('success', 'Service added successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->createService(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while creating the service.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-services');
    }

    /**
     * Update an existing service
     */
    public function updateService() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-services');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No service ID provided');
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'icon_class' => trim($_POST['icon_class'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $this->serviceModel->updateService($id, $data);
            $this->setFlashMessage('success', 'Service updated successfully.');

        } catch (\InvalidArgumentException $e) {
            $this->setFlashMessage('error', $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in AdminController->updateService(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the service.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-services');
    }

    /**
     * Delete a service
     */
    public function deleteService() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No service ID provided');
            }

            // Check if service exists and delete it
            if ($this->serviceModel->getServiceById($id)) {
                $this->serviceModel->deleteService($id);
                $this->setFlashMessage('success', 'Service deleted successfully.');
            } else {
                throw new \Exception('Service not found');
            }

        } catch (\Exception $e) {
            error_log("Error in AdminController->deleteService(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while deleting the service: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/manage-services');
    }

    /**
     * Display library information management page
     */
    public function manageLibrary() {
        try {
            $collegeInfo = new \App\Models\CollegeInfo();
            $sections = $collegeInfo->getAllSections();

            $data = [
                'pageTitle' => 'Manage Library Information - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_library',
                'layout' => 'admin',
                'sections' => $sections,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_library', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageLibrary(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the library information.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Update library section
     */
    public function updateLibrarySection() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-library');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No section ID provided');
            }

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? '')
            ];

            $collegeInfo = new \App\Models\CollegeInfo();
            $collegeInfo->updateSection($id, $data);
            $this->setFlashMessage('success', 'Library section updated successfully.');

        } catch (\Exception $e) {
            error_log("Error in AdminController->updateLibrarySection(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the library section.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-library');
    }

    /**
     * Display librarian profile management page
     */
    public function manageLibrarian() {
        try {
            $librarianInfo = new \App\Models\LibrarianInfo();
            $librarian = $librarianInfo->getLibrarianInfo();
            $socialLinks = $librarianInfo->getSocialLinks();

            $data = [
                'pageTitle' => 'Manage Librarian Profile - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_librarian',
                'layout' => 'admin',
                'librarian' => $librarian,
                'social_links' => $socialLinks,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_librarian', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageLibrarian(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the librarian profile.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Update librarian information
     */
    public function updateLibrarian() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-librarian');
                return;
            }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'qualification' => trim($_POST['qualification'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'office_hours' => trim($_POST['office_hours'] ?? ''),
                'social_links' => $_POST['social_links'] ?? []
            ];

            $librarianInfo = new \App\Models\LibrarianInfo();

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = $_FILES['image']['type'];
                
                if (!in_array($fileType, $allowedTypes)) {
                    throw new \Exception('Invalid file type. Only JPG, PNG, and GIF files are allowed.');
                }

                // Generate unique filename
                $uploadDir = 'public/images/staff/';
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = 'librarian_' . time() . '.' . $extension;
                $targetPath = $uploadDir . $fileName;

                // Ensure upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Move uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    throw new \Exception('Failed to upload image. Please try again.');
                }

                $data['image_path'] = '/' . $targetPath;

                // Delete old image if exists
                $oldImage = $librarianInfo->getLibrarianInfo();
                if ($oldImage && !empty($oldImage['image_path'])) {
                    $oldPath = ltrim($oldImage['image_path'], '/');
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
            $librarianInfo->updateLibrarianInfo($data);
            $this->setFlashMessage('success', 'Librarian profile updated successfully.');

        } catch (\Exception $e) {
            error_log("Error in AdminController->updateLibrarian(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while updating the librarian profile.');
        }

        header('Location: ' . BASE_URL . '/admin/manage-librarian');
    }

    /**
     * Display FAQ management page
     */
    public function manageFAQs() {
        try {
            $faqs = $this->faqModel->getAllFAQs();
            $categories = $this->faqModel->getAllCategories();

            $data = [
                'pageTitle' => 'Manage FAQs - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_faqs',
                'layout' => 'admin',
                'faqs' => $faqs,
                'categories' => $categories,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_faqs', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageFAQs(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the FAQs.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * Create a new FAQ
     */
    public function createFAQ() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-faqs');
                return;
            }

            $data = [
                'question' => trim($_POST['question'] ?? ''),
                'answer' => trim($_POST['answer'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0)
            ];

            $this->faqModel->createFAQ($data);
            
            // Return JSON response for AJAX requests
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'FAQ added successfully.']);
                return;
            }

            $this->setFlashMessage('success', 'FAQ added successfully.');
            header('Location: ' . BASE_URL . '/admin/manage-faqs');

        } catch (\InvalidArgumentException $e) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }

            $this->setFlashMessage('error', $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/manage-faqs');
        } catch (\Exception $e) {
            error_log("Error in AdminController->createFAQ(): " . $e->getMessage());

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => 'An error occurred while creating the FAQ.']);
                return;
            }

            $this->setFlashMessage('error', 'An error occurred while creating the FAQ.');
            header('Location: ' . BASE_URL . '/admin/manage-faqs');
        }
    }

    /**
     * Update an existing FAQ
     */
    public function updateFAQ() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/admin/manage-faqs');
                return;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No FAQ ID provided');
            }

            $data = [
                'question' => trim($_POST['question'] ?? ''),
                'answer' => trim($_POST['answer'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'display_order' => intval($_POST['display_order'] ?? 0)
            ];

            $this->faqModel->updateFAQ($id, $data);
            
            // Return JSON response for AJAX requests
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'FAQ updated successfully.']);
                return;
            }

            $this->setFlashMessage('success', 'FAQ updated successfully.');
            header('Location: ' . BASE_URL . '/admin/manage-faqs');

        } catch (\InvalidArgumentException $e) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }

            $this->setFlashMessage('error', $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/manage-faqs');
        } catch (\Exception $e) {
            error_log("Error in AdminController->updateFAQ(): " . $e->getMessage());

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => 'An error occurred while updating the FAQ.']);
                return;
            }

            $this->setFlashMessage('error', 'An error occurred while updating the FAQ.');
            header('Location: ' . BASE_URL . '/admin/manage-faqs');
        }
    }

    /**
     * Delete a FAQ
     */
    public function deleteFAQ() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \Exception('No FAQ ID provided');
            }

            // Check if FAQ exists and delete it
            if ($this->faqModel->getFAQById($id)) {
                $this->faqModel->deleteFAQ($id);
                
                // Return JSON response for AJAX requests
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'FAQ deleted successfully.']);
                    return;
                }

                $this->setFlashMessage('success', 'FAQ deleted successfully.');
            } else {
                throw new \Exception('FAQ not found');
            }

        } catch (\Exception $e) {
            error_log("Error in AdminController->deleteFAQ(): " . $e->getMessage());

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => 'An error occurred while deleting the FAQ: ' . $e->getMessage()]);
                return;
            }

            $this->setFlashMessage('error', 'An error occurred while deleting the FAQ: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . '/admin/manage-faqs');
    }

    /**
     * Display contact submissions management page
     */
    public function manageContacts() {
        try {
            $status = $_GET['status'] ?? null;
            $search = $_GET['search'] ?? null;

            $submissions = $this->contactModel->getAllSubmissions($status, $search);

            $data = [
                'pageTitle' => 'Manage Contact Submissions - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_contacts',
                'layout' => 'admin',
                'submissions' => $submissions,
                'currentStatus' => $status,
                'currentSearch' => $search,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/manage_contacts', $data);
        } catch (\Exception $e) {
            error_log("Error in AdminController->manageContacts(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while loading the contact submissions.');
            header('Location: ' . BASE_URL . '/admin/dashboard');
        }
    }

    /**
     * View details of a specific contact submission
     */
    public function viewContact() {
        try {
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                throw new \Exception('Invalid or missing submission ID');
            }

            $id = intval($_GET['id']);
            
            // Get submission details
            $submission = $this->contactModel->getSubmissionById($id);
            
            // Debug log
            error_log("Fetching submission ID: " . $id);
            error_log("Submission data: " . print_r($submission, true));
            
            if (!$submission) {
                throw new \Exception('Submission not found');
            }

            // Sanitize data for display
            $sanitizedSubmission = array_map('htmlspecialchars', $submission);

            // For AJAX requests, return just the submission details
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                
                $response = [
                    'success' => true, 
                    'submission' => $sanitizedSubmission
                ];
                
                // Debug log
                error_log("Sending JSON response: " . json_encode($response));
                
                header('Content-Type: application/json');
                echo json_encode($response);
                exit; // Make sure we exit after sending JSON
            }

            // For non-AJAX requests, render the full page
            $data = [
                'pageTitle' => 'View Contact Submission - ' . SITE_NAME,
                'username' => $_SESSION['username'],
                'currentPage' => 'manage_contacts',
                'layout' => 'admin',
                'submission' => $sanitizedSubmission,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('admin/view_contact', $data);

        } catch (\Exception $e) {
            error_log("Error in AdminController->viewContact(): " . $e->getMessage());
            
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }

            $this->setFlashMessage('error', 'An error occurred while loading the submission details.');
            header('Location: ' . BASE_URL . '/admin/manage-contacts');
        }
    }

    /**
     * Update the status of a contact submission
     */
    public function updateContactStatus() {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$id || !$status) {
                throw new \Exception('Missing required parameters');
            }

            // Validate status value
            $validStatuses = ['pending', 'responded', 'archived'];
            if (!in_array($status, $validStatuses)) {
                throw new \Exception('Invalid status value');
            }

            // Update the status
            if ($this->contactModel->updateStatus($id, $status)) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                throw new \Exception('Failed to update status');
            }

        } catch (\Exception $e) {
            error_log("Error in AdminController->updateContactStatus(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}