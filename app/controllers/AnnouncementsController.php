<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Announcement;
use Exception;

class AnnouncementsController extends Controller {
    private $announcementModel;

    public function __construct() {
        parent::__construct();
        $this->announcementModel = new Announcement();
    }

    /**
     * Display all active announcements
     */
    public function index() {
        try {
            $announcements = $this->announcementModel->getActiveAnnouncements(20); // Get more announcements for the full page
            
            $data = [
                'pageTitle' => 'Announcements - ' . SITE_NAME,
                'metaDescription' => 'Latest news and announcements from ' . SITE_NAME,
                'announcements' => $announcements
            ];
            
            $this->render('announcements/index', $data);
        } catch (Exception $e) {
            error_log("Error in AnnouncementsController->index(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'An error occurred while loading announcements.'
            ]);
        }
    }

    /**
     * Display a single announcement
     */
    public function view($id = null) {
        try {
            if (!$id) {
                throw new Exception('Announcement ID not provided');
            }

            $announcement = $this->announcementModel->getById($id);
            
            if (!$announcement || !$announcement['is_active']) {
                $this->render('errors/404', [
                    'pageTitle' => 'Not Found - ' . SITE_NAME,
                    'error' => 'Announcement not found.'
                ]);
                return;
            }
            
            $data = [
                'pageTitle' => $announcement['title'] . ' - ' . SITE_NAME,
                'metaDescription' => substr(strip_tags($announcement['content']), 0, 160),
                'announcement' => $announcement
            ];
            
            $this->render('announcements/view', $data);
        } catch (Exception $e) {
            error_log("Error in AnnouncementsController->view(): " . $e->getMessage());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => 'An error occurred while loading the announcement.'
            ]);
        }
    }
}