<?php
/**
 * Admin - Manage Databases View
 */
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <h1 class="h2 mb-3">Manage Databases</h1>
    
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

    <!-- Add New Database Button -->
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDatabaseModal">
            <i class="bi bi-plus-lg"></i> Add New Database
        </button>
    </div>

    <!-- Databases Table -->
    <div class="card shadow-hover mb-4">
        <div class="card-header">
            <i class="bi bi-table me-1"></i>
            External Databases
        </div>
        <div class="card-body">
            <table id="databasesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>URL</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($databases as $db): ?>
                        <tr>
                            <td><?= htmlspecialchars($db['name']) ?></td>
                            <td><?= htmlspecialchars($db['category'] ?? 'N/A') ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($db['url']) ?>" target="_blank" rel="noopener noreferrer">
                                    <?= htmlspecialchars($db['url']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($db['description'] ?? '') ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-database" data-id="<?= $db['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-database" data-id="<?= $db['id'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Initialize DataTables and event handlers -->
<script>
    // Wait for jQuery and DataTables to load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is required but not loaded');
            return;
        }

        if (!$.fn.DataTable) {
            console.error('DataTables is required but not loaded');
            return;
        }

        // Initialize DataTable with jQuery
        $(document).ready(function() {
            $('#databasesTable').DataTable({
                order: [[0, 'asc']], // Sort by name by default
                pageLength: 10,
                responsive: true
            });

            // Delete database functionality is handled in manage_databases.js

            // Handle edit button clicks
            $('.edit-database').on('click', function() {
                const $row = $(this).closest('tr');
                const id = $(this).data('id');
                const name = $row.find('td').eq(0).text();
                const category = $row.find('td').eq(1).text();
                const url = $row.find('td').eq(2).find('a').attr('href');
                const description = $row.find('td').eq(3).text();

                // Populate the edit modal
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_category').val(category === 'N/A' ? '' : category);
                $('#edit_url').val(url);
                $('#edit_description').val(description);

                // Show the modal
                new bootstrap.Modal($('#editDatabaseModal')[0]).show();
            });
        });
    });
</script>
</div> <!-- Close admin-main div -->

<!-- Add Database Modal -->
<div class="modal fade" id="addDatabaseModal" tabindex="-1" aria-labelledby="addDatabaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDatabaseModalLabel">Add New Database</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/create-database" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL *</label>
                        <input type="url" class="form-control" id="url" name="url" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" list="categories">
                        <datalist id="categories">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category) ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Database</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this database? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Database Modal -->
<div class="modal fade" id="editDatabaseModal" tabindex="-1" aria-labelledby="editDatabaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDatabaseModalLabel">Edit Database</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>/admin/update-database" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_url" class="form-label">URL *</label>
                        <input type="url" class="form-control" id="edit_url" name="url" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category" list="categories">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Database</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Define BASE_URL for JavaScript -->
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>

<!-- Include manage_databases.js -->
<script src="<?= BASE_URL ?>/public/js/manage_databases.js?v=<?= time() ?>"></script>

<!-- Load footer with scripts -->
<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>