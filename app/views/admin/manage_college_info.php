<?php
/**
 * Manage College Information Page
 * Allows admin to edit college history, mission, vision, and overview
 */
?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage College Information</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage College Information</li>
        </ol>
    </div>

    <!-- Success/Error Messages -->
    <div id="alertsContainer">
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- College Info Sections -->
    <div class="row g-4">
        <?php foreach ($sections as $section): ?>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit <?= ucfirst(htmlspecialchars($section['section'])) ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>/admin/update-college-info" method="POST">
                            <input type="hidden" name="section" value="<?= htmlspecialchars($section['section']) ?>">
                            <input type="hidden" name="id" value="<?= $section['id'] ?>">
                            
                            <div class="mb-3">
                                <label for="title_<?= $section['section'] ?>" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title_<?= $section['section'] ?>" 
                                       name="title" value="<?= htmlspecialchars($section['title']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content_<?= $section['section'] ?>" class="form-label">Content</label>
                                <textarea class="form-control rich-text-editor" id="content_<?= $section['section'] ?>" 
                                          name="content" rows="8" required><?= htmlspecialchars($section['content']) ?></textarea>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            Last updated: <?= date('F j, Y g:i A', strtotime($section['last_updated'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Initialize TinyMCE for rich text editing -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for all textareas with class rich-text-editor
    tinymce.init({
        selector: 'textarea.rich-text-editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }'
    });

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