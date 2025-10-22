<?php
/**
 * Admin - Manage Announcements
 * Allows administrators to create, edit, delete, and toggle announcements
 */
?>

<!-- Sidebar -->
<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Announcements</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
            <i class="bi bi-plus-circle me-2"></i>Add New Announcement
        </button>
    </div>

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
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Date Posted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($announcements)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-info-circle me-2"></i>No announcements found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <tr>
                            <td><?= htmlspecialchars($announcement['title']) ?></td>
                            <td><?= date('M d, Y', strtotime($announcement['date_posted'])) ?></td>
                            <td>
                                <button class="btn btn-sm status-toggle <?= $announcement['is_active'] ? 'btn-success' : 'btn-secondary' ?>"
                                        onclick="toggleStatus(<?= $announcement['id'] ?>, this)"
                                        data-active="<?= $announcement['is_active'] ?>">
                                    <?= $announcement['is_active'] ? 'Active' : 'Inactive' ?>
                                </button>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="editAnnouncement(<?= $announcement['id'] ?>)"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteAnnouncement(<?= $announcement['id'] ?>)"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAnnouncementForm" method="POST" action="<?= BASE_URL ?>/admin/announcements/store" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_posted" class="form-label">Date Posted</label>
                        <input type="date" class="form-control" id="date_posted" name="date_posted" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Announcement Modal -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAnnouncementForm" method="POST">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Content</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date_posted" class="form-label">Date Posted</label>
                        <input type="date" class="form-control" id="edit_date_posted" name="date_posted" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">Active</label>
                        </div>
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
<div class="modal fade" id="deleteAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this announcement? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let announcementToDelete = null;

function editAnnouncement(id) {
    // Fetch announcement data via AJAX
    fetch(`<?= BASE_URL ?>/admin/announcements/get/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_content').value = data.content;
            document.getElementById('edit_date_posted').value = data.date_posted;
            document.getElementById('edit_is_active').checked = data.is_active == 1;
            
            document.getElementById('editAnnouncementForm').action = 
                `<?= BASE_URL ?>/admin/announcements/update/${id}`;
            
            new bootstrap.Modal(document.getElementById('editAnnouncementModal')).show();
        })
        .catch(error => {
            alert('Error fetching announcement data');
            console.error('Error:', error);
        });
}

function deleteAnnouncement(id) {
    announcementToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteAnnouncementModal')).show();
}

function confirmDelete() {
    if (announcementToDelete) {
        window.location.href = `<?= BASE_URL ?>/admin/announcements/delete/${announcementToDelete}`;
    }
}

function toggleStatus(id, button) {
    const isCurrentlyActive = button.getAttribute('data-active') === '1';
    
    fetch(`<?= BASE_URL ?>/admin/announcements/toggle/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button appearance
            button.classList.remove(isCurrentlyActive ? 'btn-success' : 'btn-secondary');
            button.classList.add(isCurrentlyActive ? 'btn-secondary' : 'btn-success');
            button.textContent = isCurrentlyActive ? 'Inactive' : 'Active';
            button.setAttribute('data-active', isCurrentlyActive ? '0' : '1');
        } else {
            alert('Error toggling announcement status');
        }
    })
    .catch(error => {
        alert('Error toggling announcement status');
        console.error('Error:', error);
    });
}

// Form validation and error handling
document.querySelectorAll('#addAnnouncementForm, #editAnnouncementForm').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple validation
        const title = this.querySelector('[name="title"]').value.trim();
        const content = this.querySelector('[name="content"]').value.trim();
        const datePosted = this.querySelector('[name="date_posted"]').value;

        if (!title || !content || !datePosted) {
            alert('Please fill in all required fields');
            return;
        }

        // Add loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

        // Submit the form
        try {
            this.submit();
        } catch (error) {
            alert('An error occurred while saving the announcement');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
</script>