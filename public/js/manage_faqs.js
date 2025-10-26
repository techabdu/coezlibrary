document.addEventListener('DOMContentLoaded', function() {
    // Form submission handlers
    setupFormSubmission('addFAQModal', 'POST', '/admin/create-faq', 'FAQ added successfully');
    setupFormSubmission('editFAQModal', 'POST', '/admin/update-faq', 'FAQ updated successfully');
    setupDeleteHandler();

    // Initialize any form validation
    initializeFormValidation();
});

function setupFormSubmission(modalId, method, endpoint, successMessage) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const form = modal.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const formData = new FormData(form);
            const response = await fetch(BASE_URL + endpoint, {
                method: method,
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                showAlert('success', successMessage);
                // Close modal and refresh page
                bootstrap.Modal.getInstance(modal).hide();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('danger', result.error || 'An error occurred');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('danger', 'An unexpected error occurred');
        }
    });
}

function setupDeleteHandler() {
    const deleteForm = document.getElementById('deleteFAQForm');
    if (!deleteForm) return;

    deleteForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const formData = new FormData(deleteForm);
            const response = await fetch(BASE_URL + '/admin/delete-faq', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                showAlert('success', 'FAQ deleted successfully');
                // Close modal and refresh page
                bootstrap.Modal.getInstance(document.getElementById('deleteFAQModal')).hide();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('danger', result.error || 'An error occurred while deleting');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('danger', 'An unexpected error occurred');
        }
    });
}

function initializeFormValidation() {
    // Add custom validation logic here if needed
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

function showAlert(type, message) {
    const alertsContainer = document.getElementById('alertsContainer');
    if (!alertsContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.role = 'alert';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertsContainer.appendChild(alert);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }, 5000);
}

// Utility function to validate form inputs
function validateInput(input, rules = {}) {
    let isValid = true;
    let errorMessage = '';

    if (rules.required && !input.value.trim()) {
        isValid = false;
        errorMessage = 'This field is required';
    } else if (rules.minLength && input.value.length < rules.minLength) {
        isValid = false;
        errorMessage = `Minimum length is ${rules.minLength} characters`;
    } else if (rules.maxLength && input.value.length > rules.maxLength) {
        isValid = false;
        errorMessage = `Maximum length is ${rules.maxLength} characters`;
    }

    // Add custom validation feedback
    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.textContent = errorMessage;
    }

    input.classList.toggle('is-invalid', !isValid);
    input.classList.toggle('is-valid', isValid);

    return isValid;
}

// Reset form and validation state
function resetForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.reset();
    form.classList.remove('was-validated');
    const inputs = form.querySelectorAll('.is-invalid, .is-valid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
    });
}