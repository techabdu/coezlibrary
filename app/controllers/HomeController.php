<?php
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->render('home', [
            'pageTitle' => 'Home',
            'metaDescription' => 'Welcome to the College E-Library - Your gateway to digital learning resources.'
        ]);
    }
}