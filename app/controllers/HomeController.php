<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Announcement;
use App\Models\LibraryInfo;
use App\Models\CarouselImage;
use Exception;

class HomeController extends Controller {
    private $announcementModel;
    private $libraryInfoModel;
    private $carouselModel;

    /**
     * Constructor - Initialize required models
     */
    public function __construct() {
        parent::__construct();
        $this->announcementModel = new Announcement();
        $this->libraryInfoModel = new LibraryInfo();
        $this->carouselModel = new CarouselImage();
    }

    /**
     * Index/Homepage method
     * Loads and displays the homepage with all required data
     */
    public function index() {
        try {
            // Get latest announcements
            $announcements = $this->announcementModel->getActiveAnnouncements();
            
            // Get library information
            $libraryInfo = $this->libraryInfoModel->getLibraryInfo();
            
            // Get carousel images
            $carouselImages = $this->carouselModel->getActiveImages();
            
            // Prepare data for the view
            $data = [
                'pageTitle' => SITE_NAME . ' - Welcome',
                'metaDescription' => 'Welcome to ' . SITE_NAME . '. Access our digital resources, e-books, e-journals, and more.',
                'announcements' => $announcements,
                'libraryInfo' => $libraryInfo,
                'carouselImages' => $carouselImages
            ];
            
            // Load the view with data
            $this->render('home', $data);
        } catch (Exception $e) {
            // Log the error
            error_log("Error in HomeController->index(): " . $e->getMessage());
            
            // Show error page with generic message
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'An error occurred while loading the homepage.'
            ]);
        }
    }

    /**
     * View a single announcement
     * @param int $id Announcement ID
     */
    public function viewAnnouncement($id = null) {
        try {
            if (!$id) {
                throw new Exception('Announcement ID not provided');
            }

            // Get the announcement
            $announcement = $this->announcementModel->getById($id);
            
            if (!$announcement || !$announcement['is_active']) {
                $this->render('errors/404', [
                    'pageTitle' => 'Not Found - ' . SITE_NAME,
                    'error' => 'Announcement not found.'
                ]);
                return;
            }

            // Prepare data for the view
            $data = [
                'pageTitle' => $announcement['title'] . ' - ' . SITE_NAME,
                'metaDescription' => substr(strip_tags($announcement['content']), 0, 160),
                'announcement' => $announcement
            ];

            // Load the view
            $this->render('home/announcement', $data);
            
        } catch (Exception $e) {
            error_log("Error in HomeController->viewAnnouncement(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'An error occurred while loading the announcement.'
            ]);
        }
    }
}