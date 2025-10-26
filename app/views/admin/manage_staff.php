<?php
/**
 * Manage Library Staff Members
 * Allows admin to manage staff member profiles and information
 */
?>

<!-- Main Content -->
<div class="admin-main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">Manage Staff Members</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Staff Members</li>
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

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Staff Member
            </button>
        </div>
    </div>

    <!-- Staff Members Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-people me-2"></i>
                    Library Staff Members
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="staffTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Display Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($staff_members)): ?>
                            <?php foreach ($staff_members as $staff): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($staff['image_path'])): ?>
                                            <img src="<?= BASE_URL . $staff['image_path'] ?>" 
                                                 class="rounded-circle me-2" width="30" height="30" 
                                                 alt="<?= htmlspecialchars($staff['name']) ?>">
                                        <?php endif; ?>
                                        <?= htmlspecialchars($staff['name']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($staff['position']) ?></td>
                                    <td><?= htmlspecialchars($staff['department']) ?></td>
                                    <td><?= htmlspecialchars($staff['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $staff['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $staff['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td><?= (int)$staff['display_order'] ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editStaffModal" 
                                                    data-staff='<?= htmlspecialchars(json_encode($staff), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="confirmDeleteStaff(<?= $staff['id'] ?>)">
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

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>/admin/create-staff" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" name="department">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" class="form-control" id="joining_date" name="joining_date">
                        </div>
                        
                        <div class="col-12">
                            <label for="qualification" class="form-label">Qualification</label>
                            <textarea class="form-control" id="qualification" name="qualification" rows="2"></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="office_hours" class="form-label">Office Hours</label>
                            <textarea class="form-control" id="office_hours" name="office_hours" rows="2"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Max size: 2MB, Recommended: 400x400px</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Staff Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editStaffForm" action="<?= BASE_URL ?>/admin/update-staff" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="edit_position" name="position" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="edit_department" name="department">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_joining_date" class="form-label">Joining Date</label>
                            <input type="date" class="form-control" id="edit_joining_date" name="joining_date">
                        </div>
                        
                        <div class="col-12">
                            <label for="edit_qualification" class="form-label">Qualification</label>
                            <textarea class="form-control" id="edit_qualification" name="qualification" rows="2"></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label for="edit_bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="edit_bio" name="bio" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_office_hours" class="form-label">Office Hours</label>
                            <textarea class="form-control" id="edit_office_hours" name="office_hours" rows="2"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="edit_display_order" name="display_order">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <div class="form-text">Max size: 2MB, Recommended: 400x400px</div>
                            <div id="current_image_preview" class="mt-2"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                                <label class="form-check-label" for="edit_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Staff Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this staff member? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteStaffForm" action="<?= BASE_URL ?>/admin/delete-staff" method="POST">
                    <input type="hidden" name="id" id="delete_staff_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize DataTable and Handle Modal Events -->
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#staffTable').DataTable({
        responsive: true,
        order: [[5, 'asc']], // Sort by display order by default
        columnDefs: [
            { orderable: false, targets: [6] } // Disable sorting for actions column
        ]
    });

    // Handle edit modal
    $('#editStaffModal').on('show.bs.modal', function (event) {
        try {
            var button = $(event.relatedTarget);
            var staffJson = button.data('staff');
            var staff = (typeof staffJson === 'string') ? JSON.parse(staffJson) : staffJson;
            
            if (!staff) {
                console.error('Staff data is missing');
                return;
            }

            // Populate form fields
            $('#edit_id').val(staff.id);
            $('#edit_name').val(staff.name || '');
            $('#edit_position').val(staff.position || '');
            $('#edit_department').val(staff.department || '');
            $('#edit_email').val(staff.email || '');
            $('#edit_phone').val(staff.phone || '');
            $('#edit_joining_date').val(staff.joining_date || '');
            $('#edit_qualification').val(staff.qualification || '');
            $('#edit_bio').val(staff.bio || '');
            $('#edit_office_hours').val(staff.office_hours || '');
            $('#edit_display_order').val(staff.display_order || 0);
            $('#edit_is_active').prop('checked', staff.is_active == 1);

            // Show current image if exists
            var imagePreview = $('#current_image_preview');
            if (staff.image_path) {
                imagePreview.html(`
                    <img src="${BASE_URL}${staff.image_path}" 
                         class="img-thumbnail" 
                         style="max-width: 100px;" 
                         alt="Current profile image">
                `);
            } else {
                imagePreview.empty();
            }
        } catch (e) {
            console.error('Error populating edit form:', e);
        }
    });

    // Preview image before upload (Add form)
    $('#image').on('change', function(e) {
        previewImage(this, 'add');
    });

    // Preview image before upload (Edit form)
    $('#edit_image').on('change', function(e) {
        previewImage(this, 'edit');
    });
});

// Image preview function
function previewImage(input, formType) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var previewContainer = formType === 'edit' ? '#current_image_preview' : null;
            if (previewContainer) {
                $(previewContainer).html(`
                    <img src="${e.target.result}" 
                         class="img-thumbnail" 
                         style="max-width: 100px;" 
                         alt="Profile image preview">
                `);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle delete confirmation
function confirmDeleteStaff(staffId) {
    $('#delete_staff_id').val(staffId);
    $('#deleteStaffModal').modal('show');
}

// Auto-dismiss alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>