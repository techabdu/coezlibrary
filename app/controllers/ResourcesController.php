<?php
namespace App\Controllers;

require_once __DIR__ . '/../../core/Controller.php';

use Core\Controller;

class ResourcesController extends Controller {
    /**
     * Display the e-books page
     */
    public function ebooks() {
        $this->render('resources/ebooks');
    }

    /**
     * Display the e-journals page
     */
    public function ejournals() {
        $this->render('resources/ejournals');
    }
}