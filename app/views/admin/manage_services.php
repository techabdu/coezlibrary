<?php
$categories = [
    'General Services',
    'Research Support',
    'Technology Services',
    'Study Support',
    'Special Services'
];
?>

<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Services</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Services</li>
        </ol>
    </div>

    <!-- Success/Error Messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

        <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Service
            </button>
        </div>
    </div>

    <!-- Services Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-table me-1"></i>
                    Library Services
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="servicesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Icon</th>
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
                                    <td><?= htmlspecialchars($service['category']) ?></td>
                                    <td><?= htmlspecialchars(substr($service['description'], 0, 100)) ?>...</td>
                                    <td><i class="bi <?= htmlspecialchars($service['icon_class']) ?>"></i></td>
                                    <td><?= (int)$service['display_order'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $service['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $service['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-primary btn-sm edit-service-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editServiceModal" 
                                                    data-service="<?= htmlspecialchars(json_encode($service), ENT_QUOTES, 'UTF-8') ?>"
                                                    aria-label="Edit service">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete(<?= $service['id'] ?>)"
                                                    aria-label="Delete service">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
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
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/create-service" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="icon_class" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <input type="text" class="form-control" id="icon_class" name="icon_class" 
                               placeholder="e.g., bi-book, bi-journal-text">
                        <div class="form-text">Enter a Bootstrap Icons class name. <a href="https://icons.getbootstrap.com/" target="_blank">Browse icons</a></div>
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="0">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editServiceForm" action="<?= BASE_URL ?>/admin/update-service" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" tabindex="0"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <select class="form-select" id="edit_category" name="category">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_icon_class" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <input type="text" class="form-control" id="edit_icon_class" name="icon_class">
                        <div class="form-text">Enter a Bootstrap Icons class name. <a href="https://icons.getbootstrap.com/" target="_blank">Browse icons</a></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit_display_order" name="display_order">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                            <label class="form-check-label" for="edit_is_active">
                                Active
                            </label>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteServiceModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this service? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteServiceForm" action="<?= BASE_URL ?>/admin/delete-service" method="POST" style="display: inline;">
                    <input type="hidden" name="id" id="delete_service_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Load Service Management JavaScript -->
<script src="<?= BASE_URL ?>/public/js/manage_services.js"></script>

<!-- Initialize DataTable -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#servicesTable').DataTable({
                responsive: true,
                order: [[4, 'asc']], // Sort by display order by default
                columnDefs: [
                    { orderable: false, targets: [3, 6] } // Disable sorting for icon and actions columns
                ],
                language: {
                    emptyTable: 'No services available',
                    zeroRecords: 'No matching services found'
                }
            });
        } else {
            console.error('DataTables is not loaded. Please check your script includes.');
        }
    } catch (error) {
        console.error('Error initializing DataTable:', error);
    }
});

// Handle delete confirmation
function confirmDelete(serviceId) {
    $('#delete_service_id').val(serviceId);
    $('#deleteServiceModal').modal('show');
}
</script>

