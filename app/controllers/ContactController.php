<?php
/**
 * Contact Controller
 * Handles contact form display and submission
 */

namespace App\Controllers;

use Core\Controller;
use App\Models\Contact;
use App\Models\LibraryInfo;

class ContactController extends Controller {
    private $contactModel;
    private $libraryInfoModel;

    public function __construct() {
        parent::__construct();
        $this->contactModel = new Contact();
        $this->libraryInfoModel = new LibraryInfo();
    }

    /**
     * Display the contact form page
     */
    public function index() {
        try {
            // Get library contact information to display on the page
            $libraryInfo = $this->libraryInfoModel->getLibraryInfo();
            
            $data = [
                'pageTitle' => 'Contact Us / Ask a Librarian',
                'libraryInfo' => $libraryInfo,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('contact', $data);
        } catch (\Exception $e) {
            error_log("Error in ContactController->index(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error',
                'error' => 'An error occurred while loading the contact page.'
            ]);
        }
    }

    /**
     * Handle contact form submission
     */
    public function submit() {
        try {
            // Check if it's a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . BASE_URL . '/contact');
                exit();
            }

            // Validate required fields
            $requiredFields = ['name', 'email', 'subject', 'message'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['flash_error'] = 'Please fill in all required fields.';
                    header('Location: ' . BASE_URL . '/contact');
                    exit();
                }
            }

            // Validate email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_error'] = 'Please enter a valid email address.';
                header('Location: ' . BASE_URL . '/contact');
                exit();
            }

            // Sanitize input data
            $submissionData = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'subject' => htmlspecialchars(trim($_POST['subject'])),
                'message' => htmlspecialchars(trim($_POST['message']))
            ];

            // Save to database
            if ($this->contactModel->saveSubmission($submissionData)) {
                error_log("Contact form submitted successfully for: " . $submissionData['email']);
                $_SESSION['flash_success'] = 'Your message has been sent! We\'ll respond within 24 hours.';
            } else {
                error_log("Failed to save contact form submission for: " . $submissionData['email']);
                $_SESSION['flash_error'] = 'Sorry, there was a problem sending your message. Please try again later.';
            }

        } catch (\Exception $e) {
            error_log("Error in ContactController->submit(): " . $e->getMessage());
            $_SESSION['flash_error'] = 'An error occurred while processing your request.';
        }

        // Redirect back to contact page
        header('Location: ' . BASE_URL . '/contact');
        exit();
    }

    /**
     * Set a flash message in session
     */
    private function setFlashMessage(string $type, string $message): void {
        $_SESSION['flash_' . $type] = $message;
    }

    /**
     * Get and clear a flash message from session
     */
    private function getFlashMessage(string $type): ?string {
        $message = $_SESSION['flash_' . $type] ?? null;
        unset($_SESSION['flash_' . $type]);
        return $message;
    }

}