// Main JavaScript file for managing announcements
$(document).ready(function() {
    // Store references to frequently used elements
    const $table = $('#announcementsTable');
    let selectedAnnouncement = null;
    
    // Initialize DataTable with full width settings
    const dataTable = $table.DataTable({
        order: [[2, 'desc']], // Sort by date posted by default
        pageLength: 10,
        responsive: true,
        autoWidth: false,
        scrollX: false,
        columns: [
            { width: '20%' }, // Title
            { width: '40%' }, // Content
            { width: '15%' }, // Date Posted
            { width: '10%' }, // Status
            { width: '15%' }  // Actions
        ]
    });

    // Initialize modals
    const deleteModal = new bootstrap.Modal('#deleteConfirmModal');
    const editModal = new bootstrap.Modal('#editAnnouncementModal');
    
    // Handle delete button clicks
    $table.on('click', '.delete-announcement', function(e) {
        e.preventDefault();
        const $button = $(this);
        
        // Store the announcement information
        selectedAnnouncement = {
            id: $button.data('id'),
            title: $button.closest('tr').find('td:first').text().trim()
        };
        
        // Update modal text and show it
        $('#deleteConfirmModal .modal-body').text(
            `Are you sure you want to delete the announcement "${selectedAnnouncement.title}"? This action cannot be undone.`
        );
        deleteModal.show();
    });

    // Handle delete confirmation
    $('#confirmDelete').on('click', function() {
        if (!selectedAnnouncement) return;

        // Create and submit the form
        const $form = $('<form>', {
            method: 'POST',
            action: `${BASE_URL}/admin/delete-announcement`
        });

        // Add the announcement ID
        $('<input>').attr({
            type: 'hidden',
            name: 'id',
            value: selectedAnnouncement.id
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