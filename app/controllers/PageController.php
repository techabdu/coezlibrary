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
     * About page
     */
    public function about() {
        try {
            $pageContent = $this->staticPageModel->getPageBySlug('about-us');
            
            $data = [
                'pageTitle' => 'About Us - ' . SITE_NAME,
                'metaDescription' => 'Learn about our library, our mission, and our dedicated staff.',
                'content' => $pageContent,
                'breadcrumbs' => [
                    ['title' => 'Home', 'link' => BASE_URL],
                    ['title' => 'About Us', 'link' => null]
                ]
            ];
            
            $this->render('pages/about', $data);
        } catch (Exception $e) {
            error_log("Error in PageController->about(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'Failed to load the About page.'
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
     * Policies page
     */
    public function policies() {
        try {
            $pageContent = $this->staticPageModel->getPageBySlug('policies');
            
            $data = [
                'pageTitle' => 'Library Policies - ' . SITE_NAME,
                'metaDescription' => 'View our library policies, rules, and guidelines.',
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