// Main JavaScript file for managing policies
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery and DataTables to be available
    function initializeWhenReady() {
        // Check for jQuery
        if (typeof jQuery === 'undefined') {
            console.log('Waiting for jQuery to load...');
            setTimeout(initializeWhenReady, 50);
            return;
        }

        // Check for DataTables
        if (!jQuery.fn.DataTable) {
            console.log('Waiting for DataTables to load...');
            setTimeout(initializeWhenReady, 50);
            return;
        }
        
        console.log('Dependencies loaded, initializing policies table...');
        initializePoliciesTable();
    }

    function initializePoliciesTable() {
        // Store references to frequently used elements
        const $table = $('#policiesTable');
        if (!$table.length) {
            console.error('Policies table not found');
            return;
        }
        
        let selectedPolicy = null;
        let dataTable = null;

        try {
            // Initialize DataTable if not already initialized
            if (!$.fn.DataTable.isDataTable($table)) {
                dataTable = $table.DataTable({
                    order: [[3, 'asc']], // Sort by display order by default
                    pageLength: 10,
                    autoWidth: false,
                    responsive: true,
                    columns: [
                        { width: '20%' }, // Title
                        { width: '10%' }, // Category
                        { width: '35%' }, // Content
                        { width: '10%' }, // Order
                        { width: '10%' }, // Status
                        { width: '15%' }  // Actions
                    ]
                });
            } else {
                dataTable = $table.DataTable();
            }

            // Initialize modals
            const $deleteModal = $('#deleteConfirmModal');
            const $editModal = $('#editPolicyModal');
            
            if (!$deleteModal.length || !$editModal.length) {
                console.error('Required modals not found');
                return;
            }

            const deleteModal = new bootstrap.Modal($deleteModal[0]);
            const editModal = new bootstrap.Modal($editModal[0]);
            
            // Handle delete button clicks
            $(document).on('click', '.delete-policy', function(e) {
                e.preventDefault();
                const $button = $(this);
                const $row = $button.closest('tr');
                
                selectedPolicy = {
                    id: $button.data('id'),
                    title: $row.find('td:first').text().trim()
                };
                
                if (!selectedPolicy.id || !selectedPolicy.title) {
                    console.error('Invalid policy data for deletion');
                    return;
                }
                
                $deleteModal.find('.modal-body').text(
                    `Are you sure you want to delete the policy "${selectedPolicy.title}"? This action cannot be undone.`
                );
                deleteModal.show();
            });

            // Handle delete confirmation
            $('#confirmDelete').on('click', async function() {
                if (!selectedPolicy || !selectedPolicy.id) return;

                try {
                    const formData = new FormData();
                    formData.append('id', selectedPolicy.id);

                    const response = await fetch(`${BASE_URL}/admin/delete-policy`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    let data;
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        data = await response.json();
                    } else {
                        throw new Error('Invalid response format from server');
                    }

                    if (!response.ok) {
                        throw new Error(data.error || 'An error occurred while deleting the policy.');
                    }

                    // Close the delete modal
                    deleteModal.hide();
                    
                    // Show success message
                    alert(data.message || 'Policy deleted successfully');
                    
                    // Refresh the page to show updated data
                    window.location.reload();
                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while deleting the policy.');
                }
            });
            
            // Handle edit button clicks using event delegation
            $(document).on('click', '.edit-policy', function(e) {
                e.preventDefault();
                const $row = $(this).closest('tr');
                const policyId = $(this).data('id');
                
                if (!policyId) {
                    console.error('Invalid policy ID for editing');
                    return;
                }
                
                // Populate the edit modal
                $('#edit_id').val(policyId);
                $('#edit_title').val($row.find('td:eq(0)').text().trim());
                $('#edit_category').val($row.find('td:eq(1)').text().trim());
                
                // Get the full content
                const fullContent = $row.find('td:eq(2)').text().trim();
                const content = fullContent.endsWith('...') 
                    ? fullContent.slice(0, -3) // Remove the '...'
                    : fullContent;
                $('#edit_content').val(content);
                
                $('#edit_display_order').val($row.find('td:eq(3)').text().trim());
                
                // Handle active state
                const isActive = $row.find('td:eq(4) .badge').hasClass('bg-success');
                $('#edit_is_active').prop('checked', isActive);

                // Show the modal
                editModal.show();
            });

            // Handle edit form submission
            $('#editPolicyModal form').on('submit', async function(e) {
                e.preventDefault();
                const $form = $(this);

                try {
                    const formData = new FormData($form[0]);

                    const response = await fetch(`${BASE_URL}/admin/update-policy`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    let data;
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        data = await response.json();
                    } else {
                        throw new Error('Invalid response format from server');
                    }

                    if (!response.ok) {
                        throw new Error(data.error || 'An error occurred while updating the policy.');
                    }

                    // Close the edit modal
                    editModal.hide();
                    
                    // Show success message
                    alert(data.message || 'Policy updated successfully');
                    
                    // Refresh the page to show updated data
                    window.location.reload();
                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while updating the policy.');
                }
            });

            // Re-initialize DataTable on modal hide to refresh data
            $editModal.on('hidden.bs.modal', function() {
                if (dataTable) {
                    dataTable.draw(false);
                }
            });

        } catch (error) {
            console.error('Error initializing policies table:', error);
        }
    }

    // Start initialization
    initializeWhenReady();
});