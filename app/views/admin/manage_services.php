<?php
/**
 * Services management page
 * Allows admin to add, edit, and delete library services
 */

// Include the admin header
include APP_PATH . '/views/layouts/admin/header.php';
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
            <h1 class="h2">Manage Services</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: relative; z-index: 1050;">
                        <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: relative; z-index: 1050;">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Add New Service Button -->
                <div class="mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="bi bi-plus-lg"></i> Add New Service
                    </button>
                </div>

                <!-- Services Table -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-gear-fill me-1"></i>
                        Library Services
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="servicesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Icon Class</th>
                                    <th>Display Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($services)): ?>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($service['title']) ?></td>
                                            <td><?= htmlspecialchars(substr($service['description'], 0, 100)) ?>...</td>
                                            <td><i class="<?= htmlspecialchars($service['icon']) ?>"></i> <?= htmlspecialchars($service['icon']) ?></td>
                                            <td><?= htmlspecialchars($service['display_order']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $service['is_active'] ? 'success' : 'danger' ?>">
                                                    <?= $service['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary edit-service" 
                                                        data-service="<?= htmlspecialchars(json_encode($service)) ?>"
                                                        data-bs-toggle="modal" data-bs-target="#editServiceModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger delete-service"
                                                        data-id="<?= $service['id'] ?>"
                                                        data-title="<?= htmlspecialchars($service['title']) ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No services found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Define BASE_URL for JavaScript -->
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>

<!-- Load Scripts -->
<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>

<!-- Include DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/create-service" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="bi bi-book">
                        <small class="form-text text-muted">
                            <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Browse Bootstrap Icons</a>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="0" min="0">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/update-service" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_icon" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <input type="text" class="form-control" id="edit_icon" name="icon" placeholder="bi bi-book">
                        <small class="form-text text-muted">
                            <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Browse Bootstrap Icons</a>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit_display_order" name="display_order" min="0">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active">
                            <label class="form-check-label" for="edit_is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Service Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/delete-service" method="POST">
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the service "<span id="delete_title"></span>"?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/public/js/manage_services.js?v=<?= time() ?>"></script>
</script>