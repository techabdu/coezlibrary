<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Library Information</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Library Information</li>
        </ol>
    </div>

    <!-- Success/Error Messages -->
    <div id="alertsContainer"></div>

    <!-- Sections Management -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-building me-1"></i>
                Library Sections
            </h5>
        </div>
        <div class="card-body">
            <div class="accordion" id="sectionsAccordion">
                <?php foreach ($sections as $section): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= ucfirst($section['section']) ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse<?= ucfirst($section['section']) ?>">
                                <?= ucfirst($section['section']) ?> Section
                            </button>
                        </h2>
                        <div id="collapse<?= ucfirst($section['section']) ?>" class="accordion-collapse collapse" 
                             data-bs-parent="#sectionsAccordion">
                            <div class="accordion-body">
                                <form action="<?= BASE_URL ?>/admin/update-library-section" method="POST">
                                    <input type="hidden" name="id" value="<?= $section['id'] ?>">
                                    <input type="hidden" name="section" value="<?= $section['section'] ?>">
                                    
                                    <div class="mb-3">
                                        <label for="title_<?= $section['section'] ?>" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title_<?= $section['section'] ?>" 
                                               name="title" value="<?= htmlspecialchars($section['title']) ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="content_<?= $section['section'] ?>" class="form-label">Content</label>
                                        <textarea class="form-control" id="content_<?= $section['section'] ?>" 
                                                  name="content" rows="5" required><?= htmlspecialchars($section['content']) ?></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Update <?= ucfirst($section['section']) ?> Section</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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