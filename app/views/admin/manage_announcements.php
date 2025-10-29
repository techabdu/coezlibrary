<?php
/**
 * Admin - Manage Announcements View
 */
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <h1 class="h2 mb-3">Manage Announcements</h1>
    
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Add New Announcement Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                <i class="bi bi-plus-lg"></i> Add New Announcement
            </button>
        </div>

        <!-- Announcements Table -->
        <div class="card shadow-hover mb-4">
            <div class="card-header">
                <i class="bi bi-table me-1"></i>
                Announcements List
            </div>
            <div class="card-body">
                <div class="table-responsive-wrapper">
                    <table id="announcementsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date Posted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($announcements as $announcement): ?>
                            <tr>
                                <td><?= htmlspecialchars($announcement['title']) ?></td>
                                <td>
                                    <?= htmlspecialchars(substr($announcement['content'], 0, 100)) ?>
                                    <?= strlen($announcement['content']) > 100 ? '...' : '' ?>
                                </td>
                                <td><?= htmlspecialchars($announcement['date_posted']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $announcement['is_active'] ? 'success' : 'secondary' ?>">
                                        <?= $announcement['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-announcement" data-id="<?= $announcement['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-announcement" data-id="<?= $announcement['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnnouncementModalLabel">Add New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/create-announcement" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_posted" class="form-label">Date Posted *</label>
                        <input type="date" class="form-control" id="date_posted" name="date_posted" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Announcement Modal -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/update-announcement" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Content *</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date_posted" class="form-label">Date Posted *</label>
                        <input type="date" class="form-control" id="edit_date_posted" name="date_posted" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">
                            Active
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this announcement? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Load Scripts -->
<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>

<!-- Include DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Auto-dismiss alerts -->
<!-- Auto-dismiss alerts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>

<!-- Include manage_announcements.js -->

<!-- Define BASE_URL for JavaScript -->
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>

<!-- Include manage_announcements.js -->
<script src="<?= BASE_URL ?>/public/js/manage_announcements.js?v=<?= time() ?>"></script>
