<?php
/**
 * Admin dashboard page
 * This is a placeholder dashboard that will be expanded in later phases
 */
?>
<!-- Sidebar -->
<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
    <!-- Main Content -->
    <div class="admin-main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <span class="btn btn-sm btn-outline-secondary">
                    Welcome, <?= htmlspecialchars($username) ?>!
                </span>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 py-3">
        <div class="col-md-3">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Pages</h5>
                    <p class="h3 mb-0">5</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Services</h5>
                    <p class="h3 mb-0">8</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Staff Members</h5>
                    <p class="h3 mb-0">12</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Announcements</h5>
                    <p class="h3 mb-0">3</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Welcome to the Admin Panel</h4>
                <p>This dashboard will be expanded in future phases to include:</p>
                <ul class="mb-0">
                    <li>Content management features</li>
                    <li>User statistics</li>
                    <li>System notifications</li>
                    <li>And more...</li>
                </ul>
            </div>
        </div>
    </div>