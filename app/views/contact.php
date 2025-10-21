<?php
/**
 * Contact page view
 * Displays contact form and library contact information
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Contact Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <!-- Library Contact Information -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h4 mb-4">Library Information</h2>
                        
                        <?php if (isset($libraryInfo)): ?>
                            <div class="mb-4">
                                <h3 class="h6 text-primary"><i class="bi bi-clock me-2"></i>Library Hours</h3>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($libraryInfo['hours'] ?? '')) ?></p>
                            </div>

                            <div class="mb-4">
                                <h3 class="h6 text-primary"><i class="bi bi-geo-alt me-2"></i>Location</h3>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($libraryInfo['address'] ?? '')) ?></p>
                            </div>

                            <div class="mb-4">
                                <h3 class="h6 text-primary"><i class="bi bi-telephone me-2"></i>Phone</h3>
                                <p class="mb-0"><?= htmlspecialchars($libraryInfo['phone'] ?? '') ?></p>
                            </div>

                            <div>
                                <h3 class="h6 text-primary"><i class="bi bi-envelope me-2"></i>Email</h3>
                                <p class="mb-0">
                                    <a href="mailto:<?= htmlspecialchars($libraryInfo['email'] ?? '') ?>">
                                        <?= htmlspecialchars($libraryInfo['email'] ?? '') ?>
                                    </a>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4">Ask a Librarian</h2>

                        <!-- Flash Messages -->
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Contact Form -->
                        <form action="<?= BASE_URL ?>/contact/submit" method="POST" id="contactForm" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                                <div class="invalid-feedback">Please enter a subject.</div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                <div class="invalid-feedback">Please enter your message.</div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 100, 0, 0.8), rgba(0, 100, 0, 0.8)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
}

.contact-section .card {
    transition: transform 0.2s;
}

.contact-section .card:hover {
    transform: translateY(-5px);
}
</style>

<!-- Form Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitButton = document.getElementById('submitButton');

    // Add validation styles on form submission
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Disable submit button to prevent double submission
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
        }
        form.classList.add('was-validated');
    });

    // Real-time email validation
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('input', function() {
        if (emailInput.validity.typeMismatch) {
            emailInput.setCustomValidity('Please enter a valid email address');
        } else {
            emailInput.setCustomValidity('');
        }
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>