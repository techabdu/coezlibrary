<?php
/**
 * Manage Librarian Information Page
 * Allows admin to edit librarian details and profile
 */
?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Librarian Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Librarian Profile</li>
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

    <!-- Librarian Profile Form -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-person-badge me-2"></i>
                Edit Librarian Information
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>/admin/update-librarian-info" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $librarian['id'] ?? '' ?>">
                
                <div class="row g-4">
                    <!-- Personal Information -->
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Personal Information</h5>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= htmlspecialchars($librarian['name'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title/Position</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= htmlspecialchars($librarian['title'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="qualification" class="form-label">Qualifications</label>
                                    <textarea class="form-control" id="qualification" name="qualification" 
                                              rows="3" required><?= htmlspecialchars($librarian['qualification'] ?? '') ?></textarea>
                                    <div class="form-text">Enter each qualification on a new line</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Welcome Message</label>
                                    <textarea class="form-control rich-text-editor" id="message" name="message" 
                                              rows="5" required><?= htmlspecialchars($librarian['message'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact & Image -->
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Contact & Image</h5>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars($librarian['email'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?= htmlspecialchars($librarian['phone'] ?? '') ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="office_hours" class="form-label">Office Hours</label>
                                    <textarea class="form-control" id="office_hours" name="office_hours" 
                                              rows="2"><?= htmlspecialchars($librarian['office_hours'] ?? '') ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label d-block">Current Image</label>
                                    <?php if (!empty($librarian['image_path'])): ?>
                                        <img src="<?= BASE_URL . $librarian['image_path'] ?>" 
                                             class="img-thumbnail mb-2" alt="Librarian photo"
                                             style="max-width: 150px;">
                                    <?php else: ?>
                                        <div class="alert alert-info">No image uploaded</div>
                                    <?php endif; ?>
                                    
                                    <div class="mt-2">
                                        <label for="image" class="form-label">Upload New Image</label>
                                        <input type="file" class="form-control" id="image" name="image" 
                                               accept="image/*">
                                        <div class="form-text">Recommended size: 400x600px, Max size: 2MB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Social Media Links</h5>
                                
                                <?php 
                                $socialLinks = !empty($librarian['social_links']) 
                                    ? json_decode($librarian['social_links'], true) 
                                    : [];
                                ?>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label">LinkedIn Profile</label>
                                        <input type="url" class="form-control" id="linkedin" 
                                               name="social_links[linkedin]"
                                               value="<?= htmlspecialchars($socialLinks['linkedin'] ?? '') ?>">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="twitter" class="form-label">Twitter Profile</label>
                                        <input type="url" class="form-control" id="twitter" 
                                               name="social_links[twitter]"
                                               value="<?= htmlspecialchars($socialLinks['twitter'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Initialize TinyMCE for rich text editing -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for welcome message
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

    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.img-thumbnail');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    const newPreview = document.createElement('img');
                    newPreview.src = e.target.result;
                    newPreview.classList.add('img-thumbnail', 'mb-2');
                    newPreview.style.maxWidth = '150px';
                    const container = document.querySelector('.alert-info');
                    if (container) {
                        container.replaceWith(newPreview);
                    }
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
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