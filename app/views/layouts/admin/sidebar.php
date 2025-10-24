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
        <a href="<?= BASE_URL ?>/admin/pages" 
           class="list-group-item list-group-item-action <?= $currentPage === 'pages' ? 'active' : '' ?>">
            <i class="bi bi-file-text me-2"></i>Pages
        </a>
        <a href="<?= BASE_URL ?>/admin/announcements" 
           class="list-group-item list-group-item-action <?= $currentPage === 'announcements' ? 'active' : '' ?>">
            <i class="bi bi-megaphone me-2"></i>Announcements
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-databases" 
           class="list-group-item list-group-item-action <?= $currentPage === 'manage_databases' ? 'active' : '' ?>">
            <i class="bi bi-server me-2"></i>Manage Databases
        </a>
        <a href="<?= BASE_URL ?>/admin/carousel" 
           class="list-group-item list-group-item-action <?= $currentPage === 'carousel' ? 'active' : '' ?>">
            <i class="bi bi-images me-2"></i>Carousel Images
        </a>
        <a href="<?= BASE_URL ?>/admin/services" 
           class="list-group-item list-group-item-action <?= $currentPage === 'services' ? 'active' : '' ?>">
            <i class="bi bi-gear me-2"></i>Services
        </a>
        <a href="<?= BASE_URL ?>/admin/staff" 
           class="list-group-item list-group-item-action <?= $currentPage === 'staff' ? 'active' : '' ?>">
            <i class="bi bi-people me-2"></i>Staff Members
        </a>
        <a href="<?= BASE_URL ?>/admin/account" 
           class="list-group-item list-group-item-action <?= $currentPage === 'account' ? 'active' : '' ?>">
            <i class="bi bi-person-circle me-2"></i>Account Settings
        </a>
    </div>
</div>