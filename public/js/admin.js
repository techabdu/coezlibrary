// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarCollapse');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // File input custom text
    const fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = e.target.nextElementSibling;
            if (label) {
                label.textContent = fileName || 'Choose file';
            }
        });
    });
    
    // Enhanced Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        // Handle password confirmation matching
        const newPassword = form.querySelector('#new_password');
        const confirmPassword = form.querySelector('#confirm_password');
        if (newPassword && confirmPassword) {
            const validatePasswordMatch = () => {
                if (newPassword.value && confirmPassword.value) {
                    if (newPassword.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity('Passwords do not match');
                    } else {
                        confirmPassword.setCustomValidity('');
                    }
                }
            };
            newPassword.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);
        }

        // URL validation for database forms
        const urlInput = form.querySelector('input[type="url"]');
        if (urlInput) {
            urlInput.addEventListener('input', function() {
                const url = this.value;
                try {
                    new URL(url);
                    this.setCustomValidity('');
                } catch (_) {
                    this.setCustomValidity('Please enter a valid URL (include http:// or https://)');
                }
            });
        }

        // File upload validation
        const fileInput = form.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Size validation (max 100MB)
                    const maxSize = 100 * 1024 * 1024; // 100MB in bytes
                    if (file.size > maxSize) {
                        this.setCustomValidity('File size must not exceed 100MB');
                        return;
                    }

                    // Type validation
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        this.setCustomValidity('Please upload only JPG, PNG, or GIF files');
                        return;
                    }

                    this.setCustomValidity('');
                }
            });
        }

        // Email validation
        const emailInput = form.querySelector('input[type="email"]');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(this.value)) {
                    this.setCustomValidity('Please enter a valid email address');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Prevent double submission
        let isSubmitting = false;
        form.addEventListener('submit', event => {
            if (isSubmitting) {
                event.preventDefault();
                return;
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                isSubmitting = true;
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                    
                    // Re-enable button after 5 seconds (failsafe)
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        isSubmitting = false;
                    }, 5000);
                }
            }
            form.classList.add('was-validated');
        }, false);

        // Clear validation state when form is reset
        form.addEventListener('reset', () => {
            form.classList.remove('was-validated');
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => input.setCustomValidity(''));
        });
    });
    
    // Image preview
    const imageInputs = document.querySelectorAll('.image-upload');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.dataset.preview;
            const preview = document.getElementById(previewId);
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});