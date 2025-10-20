<?php
/**
 * PageController.php
 * Handles static page rendering and management
 */

namespace App\Controllers;

use Core\Controller;
use App\Models\StaticPage;
use Exception;

class PageController extends Controller {
    private $staticPageModel;

    /**
     * Constructor - Initialize required models
     */
    public function __construct() {
        parent::__construct();
        $this->staticPageModel = new StaticPage();
    }



    /**
     * College information page
     */
    public function college() {
        try {
            $collegeInfo = new \App\Models\CollegeInfo();
            $sections = $collegeInfo->getAllSections();
            
            $data = [
                'pageTitle' => 'The College - ' . SITE_NAME,
                'metaDescription' => 'Learn about our college history, mission, vision, and values.',
                'sections' => $sections,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => '/'],
                    ['title' => 'About', 'link' => '#'],
                    ['title' => 'The College', 'link' => null]
                ]
            ];
            
            $this->render('about/college', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->college(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the College information page.'
            ]);
        }
    }

    /**
     * Librarian profile page
     */
    public function librarian() {
        try {
            $librarianInfo = new \App\Models\LibrarianInfo();
            $librarian = $librarianInfo->getLibrarianInfo();
            $socialLinks = $librarianInfo->getSocialLinks();
            
            $data = [
                'pageTitle' => 'The Librarian - ' . SITE_NAME,
                'metaDescription' => 'Meet our head librarian and learn about their vision for the library.',
                'librarian' => $librarian,
                'social_links' => $socialLinks,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => '/'],
                    ['title' => 'About', 'link' => '#'],
                    ['title' => 'The Librarian', 'link' => null]
                ]
            ];
            
            $this->render('about/librarian', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->librarian(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the Librarian profile page.'
            ]);
        }
    }

    /**
     * Library staff page
     */
    public function staff() {
        try {
            $staffModel = new \App\Models\StaffMember();
            $staff = $staffModel->getAllActiveStaff();
            
            $data = [
                'pageTitle' => 'Our Staff - ' . SITE_NAME,
                'metaDescription' => 'Meet our dedicated library staff members.',
                'staff' => $staff,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => '/'],
                    ['title' => 'About', 'link' => '#'],
                    ['title' => 'The Staff', 'link' => null]
                ]
            ];
            
            $this->render('about/staff', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->staff(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the About page.'
            ]);
        }
    }

    /**
     * Services page
     */
    public function services() {
        try {
            $pageContent = $this->staticPageModel->getPageBySlug('services');
            
            $data = [
                'pageTitle' => 'Our Services - ' . SITE_NAME,
                'metaDescription' => 'Explore the range of library services we offer to our community.',
                'content' => $pageContent,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => BASE_URL],
                    ['title' => 'Services', 'link' => null]
                ]
            ];
            
            $this->render('pages/services', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->services(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the Services page.'
            ]);
        }
    }

    /**
     * Library Policies Page
     * Displays comprehensive library rules, guidelines, and procedures
     */
    public function policies() {
        try {
            $pageContent = $this->staticPageModel->getPageBySlug('library-policies');
            
            $data = [
                'pageTitle' => 'Library Policies - ' . SITE_NAME,
                'metaDescription' => 'Learn about our library policies, borrowing rules, computer usage guidelines, fines, code of conduct, and more.',
                'content' => $pageContent,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => BASE_URL],
                    ['title' => 'Policies', 'link' => null]
                ]
            ];
            
            $this->render('pages/policies', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->policies(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the Policies page.'
            ]);
        }
    }

    /**
     * Generic page handler for other static pages
     * @param string $slug The page slug
     */
    public function view($slug) {
        try {
            $pageContent = $this->staticPageModel->getPageBySlug($slug);
            
            if (!$pageContent) {
                $this->render('errors/404', [
                    'pageTitle' => 'Page Not Found - ' . SITE_NAME,
                    'error' => 'The requested page could not be found.'
                ]);
                return;
            }
            
            $data = [
                'pageTitle' => $pageContent['title'] . ' - ' . SITE_NAME,
                'metaDescription' => $pageContent['description'] ?? '',
                'content' => $pageContent,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => BASE_URL],
                    ['title' => $pageContent['title'], 'link' => null]
                ]
            ];
            
            $this->render('pages/view', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->view(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the requested page.'
            ]);
        }
    }
}