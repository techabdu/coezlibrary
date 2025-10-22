<?php
/**
 * Admin footer layout
 * Includes necessary JavaScript files and closing tags
 */
?>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
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