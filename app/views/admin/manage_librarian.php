<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

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
    <div id="alertsContainer"></div>

    <!-- Librarian Information Form -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-person me-1"></i>
                Librarian Information
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>/admin/update-librarian" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Profile Image -->
                    <div class="col-md-3 text-center mb-4">
                        <div class="mb-3">
                            <img src="<?= !empty($librarian['image_path']) ? BASE_URL . $librarian['image_path'] : BASE_URL . '/public/images/default-profile.jpg' ?>" 
                                 class="img-thumbnail mb-2" alt="Librarian Profile" style="max-width: 200px;">
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Recommended size: 400x400px</small>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($librarian['name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="<?= htmlspecialchars($librarian['title'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualifications</label>
                            <textarea class="form-control" id="qualification" name="qualification" rows="3" 
                                      required><?= htmlspecialchars($librarian['qualification'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Enter each qualification on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Welcome Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" 
                                      required><?= htmlspecialchars($librarian['message'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($librarian['email'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= htmlspecialchars($librarian['phone'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="office_hours" class="form-label">Office Hours</label>
                            <textarea class="form-control" id="office_hours" name="office_hours" 
                                      rows="2"><?= htmlspecialchars($librarian['office_hours'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Example: Monday-Friday: 9:00 AM - 5:00 PM</small>
                        </div>

                        <!-- Social Links -->
                        <div class="mb-3">
                            <label class="form-label">Social Media Links</label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                        <input type="url" class="form-control" name="social_links[linkedin]" 
                                               placeholder="LinkedIn Profile URL" 
                                               value="<?= htmlspecialchars($social_links['linkedin'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-twitter"></i></span>
                                        <input type="url" class="form-control" name="social_links[twitter]" 
                                               placeholder="Twitter Profile URL" 
                                               value="<?= htmlspecialchars($social_links['twitter'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

    // Display success/error messages
    const alertsContainer = document.getElementById('alertsContainer');
    <?php if (isset($success)): ?>
        alertsContainer.innerHTML += `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    <?php endif; ?>
    <?php if (isset($error)): ?>
        alertsContainer.innerHTML += `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    <?php endif; ?>
});
</script>

<style>
.img-thumbnail {
    max-height: 200px;
    width: auto;
}
</style>