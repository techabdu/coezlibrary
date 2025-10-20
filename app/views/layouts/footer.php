        </main>

        <!-- Footer -->
        <footer class="footer mt-auto py-3 bg-dark text-light">
            <div class="container">
                <div class="row">
                    <!-- Contact Info -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h5 class="text-white mb-3">Contact Us</h5>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-geo-alt-fill me-2"></i>The Collage Library, Permanent Side, F. C. T. Collage Of Education, Zuba, Abuja.</li>
                            <li><i class="bi bi-telephone-fill me-2"></i>+234 000 000 0000</li>
                            <li><i class="bi bi-envelope-fill me-2"></i>library@college.edu</li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h5 class="text-white mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="<?= BASE_URL ?>/about" class="text-light text-decoration-none">About Us</a></li>
                            <li><a href="<?= BASE_URL ?>/services" class="text-light text-decoration-none">Services</a></li>
                            <li><a href="<?= BASE_URL ?>/contact" class="text-light text-decoration-none">Contact</a></li>
                            <li><a href="<?= BASE_URL ?>/faq" class="text-light text-decoration-none">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Library Hours -->
                    <div class="col-md-4">
                        <h5 class="text-white mb-3">Library Hours</h5>
                        <ul class="list-unstyled">
                            <li>Monday - Friday: 8:00 AM - 9:00 PM</li>
                            <li>Saturday: Closed</li>
                            <li>Sunday: Closed</li>
                        </ul>
                    </div>
                </div>

                <hr class="my-4 bg-secondary">

                <!-- Copyright -->
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="<?= BASE_URL ?>/privacy" class="text-light">Privacy Policy</a>
                            </li>
                            <li class="list-inline-item">
                                <span class="text-muted">|</span>
                            </li>
                            <li class="list-inline-item">
                                <a href="<?= BASE_URL ?>/terms" class="text-light">Terms of Use</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- End of main container -->

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Main JavaScript -->
    <script src="<?= BASE_URL ?>/public/js/main.js"></script>
    
    <!-- Additional JavaScript -->
    <?php if (isset($extraJs)): ?>
        <?php foreach ($extraJs as $js): ?>
            <script src="<?= BASE_URL ?>/public/js/<?= $js ?>.js"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Auto-dismiss alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>