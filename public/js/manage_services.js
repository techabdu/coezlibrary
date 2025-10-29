document.addEventListener('DOMContentLoaded', function() {
    console.log('Services management script loaded');

    // Initialize edit modal handler
    const editServiceModal = document.getElementById('editServiceModal');
    if (editServiceModal) {
        // Remove any existing event listeners by cloning and replacing the element
        const newModal = editServiceModal.cloneNode(true);
        editServiceModal.parentNode.replaceChild(newModal, editServiceModal);
        
        // Add event listener to the new modal
        const modal = new bootstrap.Modal(newModal);
        newModal.addEventListener('show.bs.modal', function(event) {
            try {
                const button = event.relatedTarget;
                if (!button) {
                    console.error('No button found');
                    return;
                }

                const serviceJson = button.getAttribute('data-service');
                if (!serviceJson) {
                    console.error('No service data found');
                    return;
                }

                const service = JSON.parse(serviceJson);
                if (!service || !service.id) {
                    console.error('Invalid service data');
                    return;
                }

                // Set form values
                const form = this.querySelector('#editServiceForm');
                if (form) {
                    form.elements['edit_id'].value = service.id;
                    form.elements['edit_title'].value = service.title || '';
                    form.elements['edit_category'].value = service.category || '';
                    form.elements['edit_description'].value = service.description || '';
                    form.elements['edit_icon_class'].value = service.icon_class || '';
                    form.elements['edit_display_order'].value = service.display_order || 0;
                    form.elements['edit_is_active'].checked = service.is_active == 1;
                } else {
                    console.error('Form not found in modal');
                }
            } catch (e) {
                console.error('Error in modal show event:', e);
            }
        });
    }

    // Handle form submission
    const editForm = document.getElementById('editServiceForm');
    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Edit form submitted');

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                console.log('Server response:', result);

                if (response.ok && result.success) {
                    // Show success message
                    showAlert('success', result.message);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editServiceModal'));
                    if (modal) {
                        modal.hide();
                    }
                    
                    // Reload page to show updated data
                    window.location.reload();
                } else {
                    // Show error message
                    const errorMessage = result.error || 'An error occurred while updating the service.';
                    showAlert('danger', errorMessage);
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred while processing your request.');
            }
        });
    }

    // Helper function to show alerts
    function showAlert(type, message) {
        const alertsContainer = document.getElementById('alertsContainer');
        if (alertsContainer) {
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
    }

    // Handle delete confirmation
    window.confirmDelete = function(serviceId) {
        if (confirm('Are you sure you want to delete this service? This action cannot be undone.')) {
            document.getElementById('delete_service_id').value = serviceId;
            document.getElementById('deleteServiceForm').submit();
        }
    };
});