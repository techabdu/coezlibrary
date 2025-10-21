<?php
/**
 * E-Journals page view
 * Temporary Coming Soon page
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">E-Journals</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">E-Journals</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Coming Soon Section -->
<section class="coming-soon-section py-5">
    <div class="container text-center py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <i class="bi bi-journal display-1 text-primary mb-4"></i>
                <h2 class="display-4 mb-4">Coming Soon</h2>
                <p class="lead text-muted">Our e-journals collection is currently under development. Check back soon for access to our digital journal resources.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-section {
        background: linear-gradient(rgba(0, 100, 0, 1), rgba(0, 100, 0, 1)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
        color: white;
    }
</style>