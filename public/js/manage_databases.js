$(document).ready(function() {
    const $table = $('#databasesTable');
    let selectedDatabase = null;
    
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().destroy();
    }
    
    // Initialize DataTable
    const dataTable = $table.DataTable({
        order: [[0, 'asc']],
        pageLength: 10,
        responsive: true
    });

    // Initialize modals
    const deleteModal = new bootstrap.Modal('#deleteConfirmModal');
    const editModal = new bootstrap.Modal('#editDatabaseModal');
    
    // Handle delete button clicks
    $table.on('click', '.delete-database', function(e) {
        e.preventDefault();
        selectedDatabase = {
            id: $(this).data('id'),
            name: $(this).closest('tr').find('td:first').text().trim()
        };
        
        $('#deleteConfirmModal .modal-body').text(
            `Are you sure you want to delete the database "${selectedDatabase.name}"? This action cannot be undone.`
        );
        deleteModal.show();
    });

    // Handle delete confirmation
    $('#confirmDelete').on('click', function() {
        if (!selectedDatabase) return;
        
        const $form = $('<form>', {
            method: 'POST',
            action: `${BASE_URL}/admin/delete-database`
        });

        $('<input>').attr({
            type: 'hidden',
            name: 'id',
            value: selectedDatabase.id
        }).appendTo($form);

        $form.appendTo('body').submit();
    });
    
    // Handle edit button clicks
    $table.on('click', '.edit-database', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        
        $('#edit_id').val($(this).data('id'));
        $('#edit_name').val($row.find('td:eq(0)').text().trim());
        $('#edit_category').val($row.find('td:eq(1)').text().trim() === 'N/A' ? '' : $row.find('td:eq(1)').text().trim());
        $('#edit_url').val($row.find('td:eq(2) a').attr('href'));
        $('#edit_description').val($row.find('td:eq(3)').text().trim());
        
        editModal.show();
    });
});