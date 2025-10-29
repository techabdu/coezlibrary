document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be available
    function initializeWhenReady() {
        if (typeof jQuery === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            // If jQuery or DataTables is not loaded yet, try again in 100ms
            setTimeout(initializeWhenReady, 100);
            return;
        }

        let selectedDatabase = null;
        
        // Handle delete button clicks
        $(document).on('click', '.delete-database', function(e) {
            e.preventDefault();
            const $row = $(this).closest('tr');
            selectedDatabase = {
                id: $(this).data('id'),
                name: $row.find('td').eq(0).text().trim()
            };
            
            $('#deleteConfirmModal .modal-body').text(
                `Are you sure you want to delete the database "${selectedDatabase.name}"? This action cannot be undone.`
            );
            
            const deleteModal = new bootstrap.Modal($('#deleteConfirmModal')[0]);
            deleteModal.show();
        });

        // Handle delete confirmation
        $('#confirmDelete').on('click', function() {
            if (!selectedDatabase) return;
            
            const $form = $('<form>', {
                method: 'POST',
                action: `${BASE_URL}/admin/delete-database`
            }).append($('<input>', {
                type: 'hidden',
                name: 'id',
                value: selectedDatabase.id
            }));

            $form.appendTo('body').submit();
        });
    }

    // Start initialization
    initializeWhenReady();
});