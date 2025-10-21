<?php
/**
 * ResourceController.php
 * Handles all library resource related pages (databases, ebooks, ejournals)
 */

namespace App\Controllers;

use Core\Controller;
use App\Models\Database;
use Exception;

class ResourceController extends Controller {
    /**
     * Display the databases page with all external database links
     */
    public function databases() {
        try {
            // Create database model instance
            $databaseModel = new Database();
            
            // Get all databases and categories
            $databases = $databaseModel->getAllDatabases();
            $categories = $databaseModel->getAllCategories();

            // Prepare view data
            $data = [
                'pageTitle' => 'Research Databases - ' . SITE_NAME,
                'metaDescription' => 'Access our collection of academic and research databases.',
                'databases' => $databases,
                'categories' => $categories
            ];
            
            // Render the view
            $this->render('databases', $data);

        } catch (Exception $e) {
            error_log("Error in ResourceController->databases(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->render('errors/500', [
                'pageTitle' => 'Error - ' . SITE_NAME,
                'error' => DISPLAY_ERRORS ? $e->getMessage() : 'Failed to load the Databases page.'
            ]);
        }
    }
}