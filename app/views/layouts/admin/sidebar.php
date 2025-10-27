<?php
/**
 * Admin sidebar layout
 * Contains navigation links for different admin sections
 */
?>
<div class="admin-sidebar bg-dark text-light">
    <div class="sidebar-heading p-3">
        <h5 class="mb-0">Admin Navigation</h5>
    </div>
    <div class="list-group list-group-flush">
        <a href="<?= BASE_URL ?>/admin/dashboard" 
           class="list-group-item list-group-item-action <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-announcements" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_announcements' ? 'active' : '' ?>">
            <i class="bi bi-megaphone me-2"></i>Manage Announcements
        </a>

        <a href="<?= BASE_URL ?>/admin/manage-faqs" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_faqs' ? 'active' : '' ?>">
            <i class="bi bi-question-circle me-2"></i>Manage FAQs
        </a>

        <a href="<?= BASE_URL ?>/admin/manage-databases" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_databases' ? 'active' : '' ?>">
            <i class="bi bi-server me-2"></i>Manage Databases
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-policies" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_policies' ? 'active' : '' ?>">
            <i class="bi bi-shield-check me-2"></i>Manage Policies
        </a>
        <a href="<?= BASE_URL ?>/admin/carousel" 
           class="list-group-item list-group-item-action <?= $currentPage === 'carousel' ? 'active' : '' ?>">
            <i class="bi bi-images me-2"></i>Carousel Images
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-services" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_services' ? 'active' : '' ?>">
            <i class="bi bi-gear me-2"></i>Manage Services
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-library" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_library' ? 'active' : '' ?>">
            <i class="bi bi-building me-2"></i>Library Information
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-librarian" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_librarian' ? 'active' : '' ?>">
            <i class="bi bi-person-badge me-2"></i>Librarian Profile
        </a>

        <a href="<?= BASE_URL ?>/admin/manage-contacts" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_contacts' ? 'active' : '' ?>">
            <i class="bi bi-envelope me-2"></i>Contact Submissions
        </a>
        
        <a href="<?= BASE_URL ?>/admin/account" 
           class="list-group-item list-group-item-action <?= $currentPage === 'account' ? 'active' : '' ?>">
            <i class="bi bi-person-circle me-2"></i>Account Settings
        </a>
    </div>
</div>