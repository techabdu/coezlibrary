<?php include APP_PATH . '/views/layouts/admin/header.php'; ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
            <h1 class="h2">Manage Carousel Images</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">
                <i class="bi bi-plus-circle"></i> Add New Image
            </button>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Images Grid -->
        <div class="row g-4">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($image['image_path']) ?>" 
                                 class="card-img-top carousel-preview" 
                                 alt="Carousel Image">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title text-truncate" title="<?= htmlspecialchars($image['caption']) ?>">
                                        <?= htmlspecialchars($image['caption']) ?>
                                    </h5>
                                    <span class="badge <?= $image['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $image['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </div>
                                <p class="card-text small text-muted">
                                    Display Order: <?= htmlspecialchars($image['display_order']) ?>
                                </p>
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-sm btn-outline-primary edit-image" 
                                            data-id="<?= $image['id'] ?>"
                                            data-caption="<?= htmlspecialchars($image['caption']) ?>"
                                            data-order="<?= htmlspecialchars($image['display_order']) ?>"
                                            data-active="<?= $image['is_active'] ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editImageModal">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-image" 
                                            data-id="<?= $image['id'] ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteImageModal">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No carousel images found. Click "Add New Image" to get started.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Carousel Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/upload-carousel-image" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image File</label>
                        <input type="file" class="form-control" id="image" name="image" required
                               accept="image/jpeg,image/png,image/gif">
                        <div class="form-text">Accepted formats: JPG, PNG, GIF. Max size: 100MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption</label>
                        <input type="text" class="form-control" id="caption" name="caption" required>
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="0" min="0">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Carousel Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/update-carousel-image" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">New Image File (optional)</label>
                        <input type="file" class="form-control" id="edit_image" name="image"
                               accept="image/jpeg,image/png,image/gif">
                        <div class="form-text">Leave empty to keep the current image.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_caption" class="form-label">Caption</label>
                        <input type="text" class="form-control" id="edit_caption" name="caption" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit_display_order" 
                               name="display_order" min="0">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" 
                               name="is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Image Modal -->
<div class="modal fade" id="deleteImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Carousel Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this carousel image? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?= BASE_URL ?>/admin/delete-carousel-image" method="post" class="d-inline">
                    <input type="hidden" name="id" id="delete_id">
                    <button type="submit" class="btn btn-danger">Delete Image</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.carousel-preview {
    height: 200px;
    object-fit: cover;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button clicks
    document.querySelectorAll('.edit-image').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const caption = this.dataset.caption;
            const order = this.dataset.order;
            const active = this.dataset.active === '1';
            
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_caption').value = caption;
            document.getElementById('edit_display_order').value = order;
            document.getElementById('edit_is_active').checked = active;
        });
    });
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('delete_id').value = id;
        });
    });
});
</script>

<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>