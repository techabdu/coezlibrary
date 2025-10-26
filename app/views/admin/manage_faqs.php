<?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage FAQs</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage FAQs</li>
        </ol>
    </div>

    <!-- Success/Error Messages -->
    <div id="alertsContainer"></div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFAQModal">
                <i class="bi bi-plus-circle me-2"></i>Add New FAQ
            </button>
        </div>
    </div>

    <!-- FAQs Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle me-1"></i>
                    Frequently Asked Questions
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="faqsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Display Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($faqs)): ?>
                            <?php foreach ($faqs as $faq): ?>
                                <tr>
                                    <td><?= htmlspecialchars($faq['category']) ?></td>
                                    <td><?= htmlspecialchars($faq['question']) ?></td>
                                    <td><?= htmlspecialchars(substr($faq['answer'], 0, 100)) ?>...</td>
                                    <td><?= (int)$faq['display_order'] ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editFAQModal" 
                                                    data-faq='<?= htmlspecialchars(json_encode($faq), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete(<?= $faq['id'] ?>)">
                                                <i class="bi bi-trash"></i>
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

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFAQModal" tabindex="-1" aria-labelledby="addFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/create-faq" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFAQModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
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
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFAQModal" tabindex="-1" aria-labelledby="editFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFAQForm" action="<?= BASE_URL ?>/admin/update-faq" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="edit_question" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
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
                        <label for="edit_display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit_display_order" name="display_order">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFAQModal" tabindex="-1" aria-labelledby="deleteFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFAQModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this FAQ? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteFAQForm" action="<?= BASE_URL ?>/admin/delete-faq" method="POST" style="display: inline;">
                    <input type="hidden" name="id" id="delete_faq_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize DataTable -->
<script>
$(document).ready(function() {
    try {
        // Check if DataTable function exists
        if (typeof $.fn.DataTable === 'undefined') {
            console.error('DataTables is not loaded. Please check your script includes.');
            return;
        }

        // Initialize DataTable
        $('#faqsTable').DataTable({
            responsive: true,
            order: [[3, 'asc'], [0, 'asc']], // Sort by display order, then category
            columnDefs: [
                { orderable: false, targets: [4] } // Disable sorting for actions column
            ],
            language: {
                emptyTable: 'No FAQs available',
                zeroRecords: 'No matching FAQs found'
            }
        });
    } catch (error) {
        console.error('Error initializing DataTable:', error);
    }

    // Handle edit modal
    $('#editFAQModal').on('show.bs.modal', function (event) {
        try {
            var button = $(event.relatedTarget);
            var faqJson = button.data('faq');
            var faq = (typeof faqJson === 'string') ? JSON.parse(faqJson) : faqJson;
            
            if (!faq) {
                console.error('FAQ data is missing');
                return;
            }

            $('#edit_id').val(faq.id);
            $('#edit_question').val(faq.question || '');
            $('#edit_answer').val(faq.answer || '');
            $('#edit_category').val(faq.category || '');
            $('#edit_display_order').val(faq.display_order || 0);
        } catch (e) {
            console.error('Error populating edit form:', e);
        }
    });
});

// Handle delete confirmation
function confirmDelete(faqId) {
    $('#delete_faq_id').val(faqId);
    $('#deleteFAQModal').modal('show');
}
</script>

<!-- Display success/error messages -->
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