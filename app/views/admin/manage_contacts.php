<?php include APP_PATH . '/views/layouts/admin/header.php'; ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include APP_PATH . '/views/layouts/admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
            <h1 class="h2">Contact Submissions</h1>

            <!-- Search and Filter Controls -->
            <div class="d-flex gap-2">
                <form class="d-flex gap-2" method="get" action="<?= BASE_URL ?>/admin/manage-contacts">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search submissions..." 
                               name="search" value="<?= htmlspecialchars($currentSearch ?? '') ?>">
                        <select class="form-select" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" <?= ($currentStatus === 'pending') ? 'selected' : '' ?>>Pending</option>
                            <option value="responded" <?= ($currentStatus === 'responded') ? 'selected' : '' ?>>Responded</option>
                            <option value="archived" <?= ($currentStatus === 'archived') ? 'selected' : '' ?>>Archived</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <?php if (!empty($currentSearch) || !empty($currentStatus)): ?>
                            <a href="<?= BASE_URL ?>/admin/manage-contacts" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="card shadow-hover mb-4">
                <div class="card-header">
                    <i class="bi bi-table me-1"></i>
                    Contact Submissions
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="contactsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date Submitted</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($submissions)): ?>
                                    <?php foreach ($submissions as $submission): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($submission['id']) ?></td>
                                            <td><?= htmlspecialchars($submission['name']) ?></td>
                                            <td><?= htmlspecialchars($submission['email']) ?></td>
                                            <td><?= htmlspecialchars($submission['subject']) ?></td>
                                            <td><?= date('Y-m-d H:i', strtotime($submission['submitted_at'])) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $submission['status'] === 'pending' ? 'warning' : 
                                                    ($submission['status'] === 'responded' ? 'success' : 'secondary') 
                                                ?>">
                                                    <?= ucfirst(htmlspecialchars($submission['status'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary view-submission" 
                                                        data-id="<?= $submission['id'] ?>" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewSubmissionModal">
                                                    <i class="bi bi-eye"></i> View
                                                </button>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="bi bi-gear"></i> Status
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="<?= BASE_URL ?>/admin/update-contact-status" method="post" class="update-status-form">
                                                                <input type="hidden" name="id" value="<?= $submission['id'] ?>">
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item">Mark as Pending</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="<?= BASE_URL ?>/admin/update-contact-status" method="post" class="update-status-form">
                                                                <input type="hidden" name="id" value="<?= $submission['id'] ?>">
                                                                <input type="hidden" name="status" value="responded">
                                                                <button type="submit" class="dropdown-item">Mark as Responded</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="<?= BASE_URL ?>/admin/update-contact-status" method="post" class="update-status-form">
                                                                <input type="hidden" name="id" value="<?= $submission['id'] ?>">
                                                                <input type="hidden" name="status" value="archived">
                                                                <button type="submit" class="dropdown-item">Archive</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No contact submissions found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- View Submission Modal -->
<div class="modal fade" id="viewSubmissionModal" tabindex="-1" aria-labelledby="viewSubmissionModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSubmissionModalLabel">Contact Submission Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="submission-details">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary send-email">Reply via Email</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this before the closing body tag -->
<script>
// Define BASE_URL for JavaScript use
const BASE_URL = '<?= BASE_URL ?>';

document.addEventListener('DOMContentLoaded', function() {
    // Function to escape HTML content
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Handle viewing submission details
    document.querySelectorAll('.view-submission').forEach(button => {
        button.addEventListener('click', function() {
            const submissionId = this.getAttribute('data-id');
            const details = document.querySelector('.submission-details');
            
            // Fetch submission details
            fetch(`${BASE_URL}/admin/view-contact?id=${submissionId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Server returned ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (!data.success || !data.submission) {
                    throw new Error('Invalid response data');
                }
                
                const submission = data.submission;
                
                // Format the submission date
                const submittedDate = new Date(submission.submitted_at);
                const formattedDate = submittedDate.toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Update modal content
                details.innerHTML = `
                    <dl class="row">
                        <dt class="col-sm-3">Name:</dt>
                        <dd class="col-sm-9">${escapeHtml(submission.name)}</dd>

                        <dt class="col-sm-3">Email:</dt>
                        <dd class="col-sm-9">
                            <a href="mailto:${escapeHtml(submission.email)}">
                                ${escapeHtml(submission.email)}
                            </a>
                        </dd>

                        <dt class="col-sm-3">Subject:</dt>
                        <dd class="col-sm-9">${escapeHtml(submission.subject)}</dd>

                        <dt class="col-sm-3">Message:</dt>
                        <dd class="col-sm-9" style="white-space: pre-wrap;">${escapeHtml(submission.message)}</dd>

                        <dt class="col-sm-3">Submitted:</dt>
                        <dd class="col-sm-9">${formattedDate}</dd>

                        <dt class="col-sm-3">Status:</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-${
                                submission.status === 'pending' ? 'warning' : 
                                (submission.status === 'responded' ? 'success' : 'secondary')
                            }">
                                ${submission.status.charAt(0).toUpperCase() + submission.status.slice(1)}
                            </span>
                        </dd>
                    </dl>
                `;

                // Update email button
                const emailButton = document.querySelector('.send-email');
                const subject = encodeURIComponent(`Re: ${submission.subject}`);
                emailButton.onclick = function() {
                    window.location.href = `mailto:${encodeURIComponent(submission.email)}?subject=${subject}`;
                };
            })
            .catch(error => {
                console.error('Error:', error);
                details.innerHTML = '<div class="alert alert-danger">Error loading submission details</div>';
            });
        });
    });

    // Handle status update forms
    document.querySelectorAll('.update-status-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.error || 'Error updating status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                alert('Error updating status: ' + error.message);
            });
        });
    });
});
</script>

<?php include APP_PATH . '/views/layouts/admin/footer.php'; ?>

<!-- Include DataTables -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Initialize DataTables -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        const table = new DataTable('#contactsTable', {
            order: [[4, 'desc']], // Sort by date submitted by default
            pageLength: 10,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting on actions column
            ]
        });
    });
</script>