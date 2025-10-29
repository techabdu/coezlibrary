<?php
/**
 * Admin footer layout
 * Includes necessary JavaScript files and closing tags
 */
?>
        <!-- jQuery first -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- DataTables after jQuery and Bootstrap -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        
        <!-- Admin panel JavaScript -->
        <script src="<?= BASE_URL ?>/public/js/admin.js"></script>
        
        <!-- Flash message auto-hide -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-hide flash messages after 5 seconds
                setTimeout(function() {
                    const flashMessages = document.querySelectorAll('.alert.alert-dismissible');
                    flashMessages.forEach(function(message) {
                        const bsAlert = new bootstrap.Alert(message);
                        bsAlert.close();
                    });
                }, 5000);
            });
        </script>
    </body>
</html>