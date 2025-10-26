// Main JavaScript file for managing announcements
$(document).ready(function() {
    // Store references to frequently used elements
    const $table = $('#announcementsTable');
    let selectedAnnouncement = null;
    
    // Initialize DataTable
    const dataTable = $table.DataTable({
        order: [[2, 'desc']], // Sort by date posted by default
        pageLength: 10,
        responsive: true
    });

    // Initialize modals
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    const editModalEl = document.getElementById('editAnnouncementModal');
    const deleteModal = new bootstrap.Modal(deleteModalEl);
    const editModal = new bootstrap.Modal(editModalEl);
    
    // Handle delete button clicks
    $table.on('click', '.delete-announcement', function(e) {
        e.preventDefault();
        const $button = $(this);
        
        // Store the announcement information
        selectedAnnouncement = {
            id: $button.data('id'),
            title: $button.closest('tr').find('td:first').text().trim()
        };
        
        console.log('Delete clicked for announcement:', selectedAnnouncement);
        
        // Update modal text and show it
        $('#deleteConfirmModal .modal-body').text(
            `Are you sure you want to delete the announcement "${selectedAnnouncement.title}"? This action cannot be undone.`
        );
        deleteModal.show();
    });

    // Handle delete confirmation
    $('#confirmDelete').on('click', function(e) {
        e.preventDefault();
        
        if (!selectedAnnouncement) {
            console.error('No announcement selected');
            return;
        }
        
        console.log('Deleting announcement:', selectedAnnouncement);
        
        try {
            // Hide the modal first
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            if (deleteModal) {
                deleteModal.hide();
            }

            // Create the form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = BASE_URL + '/admin/delete-announcement';
            form.style.display = 'none';

            // Add the announcement ID
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = selectedAnnouncement.id;
            form.appendChild(idInput);

            // Add CSRF token if it exists
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
            }

            // Append to body and submit
            document.body.appendChild(form);
            console.log('Submitting delete form:', form);
            form.submit();
        } catch (error) {
            console.error('Error during delete:', error);
        }
    });
    
    // Handle edit button clicks
    $table.on('click', '.edit-announcement', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        
        // Populate the edit modal
        $('#edit_id').val($(this).data('id'));
        $('#edit_title').val($row.find('td:eq(0)').text().trim());
        $('#edit_content').val($row.find('td:eq(1)').text().trim());
        $('#edit_date_posted').val($row.find('td:eq(2)').text().trim());
        $('#edit_is_active').prop('checked', $row.find('td:eq(3) .badge').hasClass('bg-success'));

        // Show the modal
        editModal.show();
    });
});