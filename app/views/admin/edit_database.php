<?php
/**
 * Admin - Edit Database View
 */

// Include the admin header
include APP_PATH . '/views/layouts/admin/header.php';
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Database</h1>

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

            <!-- Back Button -->
            <div class="mb-4">
                <a href="<?= BASE_URL ?>/admin/manage-databases" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Databases
                </a>
            </div>

            <!-- Edit Database Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Database Entry
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/update-database/<?= $database['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($database['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL *</label>
                            <input type="url" class="form-control" id="url" name="url" value="<?= htmlspecialchars($database['url']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($database['category'] ?? '') ?>" list="categories">
                            <datalist id="categories">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($database['description'] ?? '') ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/admin/manage-databases" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Database</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the admin footer
include APP_PATH . '/views/layouts/admin/footer.php';
?>