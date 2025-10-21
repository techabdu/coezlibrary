<?php
/**
 * PageController.php
 * Handles the about section pages
 */

namespace App\Controllers;

use Core\Controller;
use Exception;
use App\Models\CollegeInfo;
use App\Models\LibrarianInfo;
use App\Models\StaffMember;
use App\Models\Service;
use App\Models\FAQ;

class PageController extends Controller {
    /**
     * Constructor - Initialize controller
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Display library policies
     */
    public function policies() {
        try {
            // Create policy model instance and get data
            $policyModel = new \App\Models\Policy();
            $policies = $policyModel->getAllPolicies();
            $categories = $policyModel->getAllCategories();

            // Prepare view data
            $data = [
                'pageTitle' => 'Library Policies - ' . SITE_NAME,
                'metaDescription' => 'Learn about our library policies, rules, and guidelines.',
                'policies' => $policies,
                'categories' => $categories
            ];
            
            // Render the view
            $this->render('policies', $data);

        } catch (\Exception $e) {
            error_log("Error in PageController->policies(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the Policies page.'
            ]);
        }
    }

    /**
     * Library information page
     */
    public function library() {
        try {
            // Create college info model instance and get data
            $collegeInfo = new CollegeInfo();
            $sections = $collegeInfo->getAllSections();
            
            if (empty($sections)) {
                throw new Exception('Library information not found');
            }
            
            // Prepare view data
            $data = [
                'pageTitle' => 'The Library - ' . SITE_NAME,
                'metaDescription' => 'Learn about our library history, mission, vision, and values.',
                'sections' => $sections
            ];
            
            // Render the view
            $this->render('about/library', $data);

        } catch (Exception $e) {
            error_log("Error in PageController->college(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the College information page.'
            ]);
        }
    }

    /**
     * Display the FAQ page
     */
    public function faq() {
        try {
            // Create FAQ model instance and get data
            $faqModel = new FAQ();
            $faqs = $faqModel->getAllFAQs();
            $categories = $faqModel->getAllCategories();

            // Group FAQs by category
            $faqsByCategory = [];
            foreach ($faqs as $faq) {
                $category = $faq['category'];
                if (!isset($faqsByCategory[$category])) {
                    $faqsByCategory[$category] = [];
                }
                $faqsByCategory[$category][] = $faq;
            }

            // Prepare view data
            $data = [
                'pageTitle' => 'Frequently Asked Questions - ' . SITE_NAME,
                'metaDescription' => 'Find answers to commonly asked questions about our library services.',
                'categories' => $categories,
                'faqsByCategory' => $faqsByCategory
            ];
            
            // Render the view
            $this->render('faq', $data);

        } catch (\Exception $e) {
            error_log("Error in PageController->faq(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the FAQ page.'
            ]);
        }
    }

    /**
     * Librarian profile page
     */
    public function librarian() {
        try {
            // Create librarian info model instance and get data
            $librarianInfo = new LibrarianInfo();
            $librarian = $librarianInfo->getLibrarianInfo();
            $socialLinks = $librarianInfo->getSocialLinks();
            
            if (!$librarian) {
                throw new Exception('Librarian information not found');
            }
            
            // Prepare view data
            $data = [
                'pageTitle' => 'The Librarian - ' . SITE_NAME,
                'metaDescription' => 'Meet our head librarian and learn about their vision for the library.',
                'librarian' => $librarian,
                'social_links' => $socialLinks
            ];
            
            // Render the view
            $this->render('about/librarian', $data);

        } catch (Exception $e) {
            error_log("Error in PageController->librarian(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the Librarian profile page.'
            ]);
        }
    }

    /**
     * Library staff page
     */
    /**
     * Library services page
     */
    public function services() {
        try {
            // Create service model instance and get data
            $serviceModel = new Service();
            $services = $serviceModel->getAllServices();
            
            if (empty($services)) {
                throw new Exception('No services found');
            }

            // Prepare view data
            $data = [
                'pageTitle' => 'Library Services - ' . SITE_NAME,
                'metaDescription' => 'Discover our comprehensive range of library services designed to support your academic journey.',
                'services' => $services
            ];
            
            // Render the view
            $this->render('services', $data);

        } catch (Exception $e) {
            error_log("Error in PageController->services(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the Services page.'
            ]);
        }
    }    public function staff() {
        try {
            // Create staff model instance and get data
            $staffModel = new StaffMember();
            $staff = $staffModel->getAllActiveStaff();
            
            // Prepare view data
            $data = [
                'pageTitle' => 'Our Staff - ' . SITE_NAME,
                'metaDescription' => 'Meet our dedicated library staff members.',
                'staff' => $staff
            ];
            
            // Render the view
            $this->render('about/staff', $data);

        } catch (Exception $e) {
            error_log("Error in PageController->staff(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the Library Staff page.'
            ]);
        }
    }
}