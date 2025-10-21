<?php
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
                'pageTitle' => 'Contact Us / Ask a Librarian - ' . SITE_NAME,
                'metaDescription' => 'Get in touch with our library staff. We\'re here to help with your questions and research needs.',
                'libraryInfo' => $libraryInfo,
                'success' => $this->getFlashMessage('success'),
                'error' => $this->getFlashMessage('error')
            ];

            $this->render('contact', $data);
        } catch (\Exception $e) {
            error_log("Error in ContactController->index(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'An error occurred while loading the contact page.'
            ]);
        }
    }

    /**
     * Handle contact form submission
     */
    public function submit() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                header('Location: ' . BASE_URL . '/contact');
                return;
            }

            // Validate required fields
            $requiredFields = ['name', 'email', 'subject', 'message'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $this->setFlashMessage('error', 'Please fill in all required fields.');
                    header('Location: ' . BASE_URL . '/contact');
                    return;
                }
            }

            // Validate email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->setFlashMessage('error', 'Please enter a valid email address.');
                header('Location: ' . BASE_URL . '/contact');
                return;
            }

            // Sanitize input data
            $submissionData = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'subject' => htmlspecialchars(trim($_POST['subject'])),
                'message' => htmlspecialchars(trim($_POST['message']))
            ];

            // Save submission
            if ($this->contactModel->saveSubmission($submissionData)) {
                $this->setFlashMessage('success', 'Your message has been sent! We\'ll respond within 24 hours.');
            } else {
                $this->setFlashMessage('error', 'Sorry, there was a problem sending your message. Please try again later.');
            }

        } catch (\Exception $e) {
            error_log("Error in ContactController->submit(): " . $e->getMessage());
            $this->setFlashMessage('error', 'An error occurred while processing your request.');
        }

        // Redirect back to contact page
        header('Location: ' . BASE_URL . '/contact');
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