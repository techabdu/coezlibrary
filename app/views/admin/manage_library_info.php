<?php include APP_PATH . '/views/layouts/admin/header.php'; ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
            <h1 class="h2">Manage Library Information</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Library Information Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/admin/update-library-info" method="post">
                    <div class="mb-3">
                        <label for="hours" class="form-label">Library Hours</label>
                        <textarea class="form-control" id="hours" name="hours" rows="4" required><?= htmlspecialchars($library_info['hours'] ?? '') ?></textarea>
                        <div class="form-text">Enter the library's operating hours. Use line breaks for different days.</div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= htmlspecialchars($library_info['location'] ?? '') ?>" required>
                        <div class="form-text">Building name or campus location</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?= htmlspecialchars($library_info['phone'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($library_info['email'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Complete Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($library_info['address'] ?? '') ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-clock"></i> Library Hours</h6>
                        <pre class="preview-text"><?= htmlspecialchars($library_info['hours'] ?? '') ?></pre>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-geo-alt"></i> Location</h6>
                        <p class="preview-text"><?= htmlspecialchars($library_info['location'] ?? '') ?></p>

                        <h6><i class="bi bi-telephone"></i> Contact Information</h6>
                        <p class="preview-text mb-1">
                            Phone: <?= htmlspecialchars($library_info['phone'] ?? '') ?>
                        </p>
                        <p class="preview-text mb-1">
                            Email: <a href="mailto:<?= htmlspecialchars($library_info['email'] ?? '') ?>">
                                <?= htmlspecialchars($library_info['email'] ?? '') ?>
                            </a>
                        </p>

                        <h6><i class="bi bi-building"></i> Address</h6>
                        <pre class="preview-text"><?= htmlspecialchars($library_info['address'] ?? '') ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.preview-text {
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    white-space: pre-wrap;
}
pre.preview-text {
    font-family: inherit;
    background: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
    border: none;
}
</style>

<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>