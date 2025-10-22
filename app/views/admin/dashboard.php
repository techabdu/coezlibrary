<?php
/**
 * Admin dashboard page
 * This is a placeholder dashboard that will be expanded in later phases
 */
?>

<!-- Include header -->
<?php require_once __DIR__ . '/../layouts/admin/header.php'; ?>

<!-- Dashboard Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../layouts/admin/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="btn btn-sm btn-outline-secondary">
                            Welcome, <?= htmlspecialchars($username) ?>!
                        </span>
                    </div>
                </div>
            </div>

            <!-- Placeholder content - will be expanded in future phases -->
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
        </main>
    </div>
</div>

<!-- Include footer -->
<?php require_once __DIR__ . '/../layouts/admin/footer.php'; ?>