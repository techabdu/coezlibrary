<?php include __DIR__ . '/../layouts/admin/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../layouts/admin/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Account Settings</h1>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/admin/update-account-settings" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <div class="invalid-feedback">
                                Please enter your current password.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="8">
                            <div class="form-text">Leave blank if you don't want to change the password. New password must be at least 8 characters long.</div>
                            <div class="invalid-feedback">
                                Password must be at least 8 characters long.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <div class="invalid-feedback">
                                Passwords do not match.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    
    const form = document.querySelector('.needs-validation');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Check if passwords match when new password is provided
        if (newPassword.value) {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
                event.preventDefault();
                event.stopPropagation();
            } else {
                confirmPassword.setCustomValidity('');
            }
        } else {
            confirmPassword.setCustomValidity('');
        }

        form.classList.add('was-validated');
    }, false);

    // Clear custom validity when typing in confirm password
    confirmPassword.addEventListener('input', function() {
        if (newPassword.value === confirmPassword.value) {
            confirmPassword.setCustomValidity('');
        } else {
            confirmPassword.setCustomValidity('Passwords do not match');
        }
    });
})();
</script>

<?php include __DIR__ . '/../layouts/admin/footer.php'; ?>