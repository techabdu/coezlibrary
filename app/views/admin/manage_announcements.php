<?php 
/**
 * Admin - Manage Announcements View
 * Displays a list of all announcements with actions to create, edit, delete, and toggle status
 */
?>

<!-- Sidebar -->
<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Announcements</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
                <i class="bi bi-plus-lg"></i> Add New Announcement
            </button>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Announcements Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bullhorn me-1"></i>
            All Announcements
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="announcements-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date Posted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($announcements as $announcement): ?>
                            <tr>
                                <td><?= htmlspecialchars($announcement['title']) ?></td>
                                <td><?= date('M d, Y', strtotime($announcement['date_posted'])) ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="<?= $announcement['id'] ?>"
                                               <?= $announcement['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label">
                                            <?= $announcement['is_active'] ? 'Active' : 'Inactive' ?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" 
                                            data-id="<?= $announcement['id'] ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#announcementModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" 
                                            data-id="<?= $announcement['id'] ?>">
                                        <i class="fas fa-trash"></i> Delete
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

<!-- Announcement Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">Add New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="announcementForm" method="POST" action="<?= BASE_URL ?>/admin/announcements/store">
                <div class="modal-body">
                    <input type="hidden" name="announcement_id" id="announcement_id">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="date_posted" class="form-label">Date Posted</label>
                        <input type="date" class="form-control" id="date_posted" name="date_posted" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Announcement</h5>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const announcementModal = document.getElementById('announcementModal');
    const deleteModal = document.getElementById('deleteModal');
    const announcementForm = document.getElementById('announcementForm');
    let deleteAnnouncementId = null;

    // Handle Edit Button Click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`<?= BASE_URL ?>/admin/announcements/${id}`);
                const data = await response.json();
                
                if (data.error) {
                    alert('Error loading announcement');
                    return;
                }

                // Fill form with announcement data
                document.getElementById('announcement_id').value = data.id;
                document.getElementById('title').value = data.title;
                document.getElementById('content').value = data.content;
                document.getElementById('date_posted').value = data.date_posted;
                document.getElementById('is_active').checked = data.is_active === 1;

                // Update modal title and form action
                document.getElementById('announcementModalLabel').textContent = 'Edit Announcement';
                announcementForm.action = `<?= BASE_URL ?>/admin/announcements/update/${id}`;
            } catch (error) {
                console.error('Error:', error);
                alert('Error loading announcement');
            }
        });
    });

    // Handle Delete Button Click
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            deleteAnnouncementId = this.dataset.id;
            new bootstrap.Modal(deleteModal).show();
        });
    });

    // Handle Delete Confirmation
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (deleteAnnouncementId) {
            window.location.href = `<?= BASE_URL ?>/admin/announcements/delete/${deleteAnnouncementId}`;
        }
    });

    // Handle Status Toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`<?= BASE_URL ?>/admin/announcements/toggle/${id}`);
                const data = await response.json();
                
                if (!data.success) {
                    alert('Error toggling announcement status');
                    this.checked = !this.checked; // Revert the toggle
                }

                // Update the label text
                this.nextElementSibling.textContent = this.checked ? 'Active' : 'Inactive';
            } catch (error) {
                console.error('Error:', error);
                alert('Error toggling announcement status');
                this.checked = !this.checked; // Revert the toggle
            }
        });
    });

    // Reset form when adding new announcement
    announcementModal.addEventListener('show.bs.modal', function(event) {
        if (!event.relatedTarget.classList.contains('edit-btn')) {
            announcementForm.reset();
            document.getElementById('announcement_id').value = '';
            document.getElementById('announcementModalLabel').textContent = 'Add New Announcement';
            announcementForm.action = '<?= BASE_URL ?>/admin/announcements/store';
            document.getElementById('is_active').checked = true;
            document.getElementById('date_posted').value = new Date().toISOString().split('T')[0];
        }
    });
});
</script>