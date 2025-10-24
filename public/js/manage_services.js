// Initialize DataTable
$(document).ready(function() {
    const servicesTable = $('#servicesTable').DataTable({
        order: [[3, 'asc']], // Sort by display_order by default
        responsive: true,
        columns: [
            { data: 'title' }, // Title
            { data: 'description' }, // Description
            { data: 'icon' }, // Icon
            { 
                data: 'display_order',
                type: 'num'
            }, // Display Order
            { 
                data: 'is_active',
                render: function(data) {
                    return `<span class="badge bg-${data ? 'success' : 'secondary'}">${data ? 'Active' : 'Inactive'}</span>`;
                }
            }, // Status
            { 
                data: null,
                orderable: false,
                width: "100px",
                className: "text-nowrap",
                render: function(data) {
                    return `
                        <button class="btn btn-sm btn-primary edit-service" data-service='${JSON.stringify(data)}'>
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-service" data-id="${data.id}" data-title="${data.title}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            } // Actions
        ]
    });

    // Edit Service
    $('#servicesTable').on('click', '.edit-service', function() {
        const service = $(this).data('service');
        $('#edit_id').val(service.id);
        $('#edit_title').val(service.title);
        $('#edit_description').val(service.description);
        $('#edit_icon').val(service.icon);
        $('#edit_display_order').val(service.display_order);
        $('#edit_is_active').prop('checked', service.is_active == 1);
        $('#editServiceModal').modal('show');
    });

    // Delete Service
    $('#servicesTable').on('click', '.delete-service', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        $('#delete_id').val(id);
        $('#delete_title').text(title);
        $('#deleteServiceModal').modal('show');
    });

    // Form validation
    $('form').submit(function() {
        $(this).find('button[type="submit"]').prop('disabled', true);
    });

    // Reset form on modal close
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $(this).find('button[type="submit"]').prop('disabled', false);
    });
});