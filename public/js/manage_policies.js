// Main JavaScript file for managing policies
$(document).ready(function() {
    // Store references to frequently used elements
    const $table = $('#policiesTable');
    let selectedPolicy = null;
    
    // Initialize DataTable
    const dataTable = $table.DataTable({
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

    // Initialize modals
    const deleteModal = new bootstrap.Modal('#deleteConfirmModal');
    const editModal = new bootstrap.Modal('#editPolicyModal');
    
    // Handle delete button clicks
    $table.on('click', '.delete-policy', function(e) {
        e.preventDefault();
        const $button = $(this);
        
        // Store the policy information
        selectedPolicy = {
            id: $button.data('id'),
            title: $button.closest('tr').find('td:first').text().trim()
        };
        
        // Update modal text and show it
        $('#deleteConfirmModal .modal-body').text(
            `Are you sure you want to delete the policy "${selectedPolicy.title}"? This action cannot be undone.`
        );
        deleteModal.show();
    });

    // Handle delete confirmation
    $('#confirmDelete').on('click', function() {
        if (!selectedPolicy) return;

        // Create and submit the form
        const $form = $('<form>', {
            method: 'POST',
            action: `${BASE_URL}/admin/delete-policy`
        });

        // Add the policy ID
        $('<input>').attr({
            type: 'hidden',
            name: 'id',
            value: selectedPolicy.id
        }).appendTo($form);

        // Add CSRF token if it exists
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) {
            $('<input>').attr({
                type: 'hidden',
                name: 'csrf_token',
                value: csrfToken
            }).appendTo($form);
        }

        // Append to body and submit
        $form.appendTo('body').submit();
    });
    
    // Handle edit button clicks
    $table.on('click', '.edit-policy', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        
        // Populate the edit modal
        $('#edit_id').val($(this).data('id'));
        $('#edit_title').val($row.find('td:eq(0)').text().trim());
        $('#edit_category').val($row.find('td:eq(1)').text().trim());
        $('#edit_content').val($row.find('td:eq(2)').text().trim());
        $('#edit_display_order').val($row.find('td:eq(3)').text().trim());
        $('#edit_is_active').prop('checked', $row.find('td:eq(4) .badge').hasClass('bg-success'));

        // Show the modal
        editModal.show();
    });
});