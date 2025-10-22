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

    <!-- Quick Stats -->
    <div class="row g-4 py-3">
        <!-- Announcements -->
        <div class="col-md-3">
            <div class="card stats-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Announcements</h6>
                            <h2 class="display-6 mb-0"><?= $stats['announcements'] ?></h2>
                        </div>
                        <div class="icon-shape bg-white text-primary rounded p-2">
                            <i class="bi bi-megaphone fs-4"></i>
                        </div>
                    </div>
                    <small class="d-block mt-2">Total active announcements</small>
                </div>
            </div>
        </div>

        <!-- Pending Contacts -->
        <div class="col-md-3">
            <div class="card stats-card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Pending Contacts</h6>
                            <h2 class="display-6 mb-0"><?= $stats['pending_contacts'] ?></h2>
                        </div>
                        <div class="icon-shape bg-white text-warning rounded p-2">
                            <i class="bi bi-envelope fs-4"></i>
                        </div>
                    </div>
                    <small class="d-block mt-2">Awaiting response</small>
                </div>
            </div>
        </div>

        <!-- Digital Resources -->
        <div class="col-md-3">
            <div class="card stats-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Digital Resources</h6>
                            <h2 class="display-6 mb-0"><?= $stats['ebooks'] + $stats['ejournals'] ?></h2>
                        </div>
                        <div class="icon-shape bg-white text-success rounded p-2">
                            <i class="bi bi-journal-text fs-4"></i>
                        </div>
                    </div>
                    <small class="d-block mt-2">
                        <?= $stats['ebooks'] ?> E-books, <?= $stats['ejournals'] ?> E-journals
                    </small>
                </div>
            </div>
        </div>

        <!-- Databases -->
        <div class="col-md-3">
            <div class="card stats-card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Databases</h6>
                            <h2 class="display-6 mb-0"><?= $stats['databases'] ?></h2>
                        </div>
                        <div class="icon-shape bg-white text-info rounded p-2">
                            <i class="bi bi-server fs-4"></i>
                        </div>
                    </div>
                    <small class="d-block mt-2">Active database links</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activity</h5>
                    <small class="text-muted">Last 5 activities</small>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (empty($recentActivity)): ?>
                            <div class="list-group-item text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>No recent activity
                            </div>
                        <?php else: ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">
                                                <?php if ($activity['type'] === 'announcement'): ?>
                                                    <i class="bi bi-megaphone text-primary me-2"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-envelope text-warning me-2"></i>
                                                <?php endif; ?>
                                                <?= htmlspecialchars($activity['action']) ?>
                                            </h6>
                                            <p class="mb-1 text-muted">
                                                <?= htmlspecialchars($activity['item_title']) ?>
                                            </p>
                                        </div>
                                        <small title="<?= date('Y-m-d H:i:s', strtotime($activity['date'])) ?>">
                                            <?= date('M d, Y', strtotime($activity['date'])) ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>