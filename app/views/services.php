<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Library Services</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Services</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-5">
    <!-- Services Grid -->
    <div class="row g-4">
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="col-lg-6">
                    <div class="card h-100 shadow-hover border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-light text-accent rounded-3 p-3 me-3">
                                    <i class="bi <?= htmlspecialchars($service['icon']) ?> fs-4"></i>
                                </div>
                                <h2 class="h4 mb-0"><?= htmlspecialchars($service['title']) ?></h2>
                            </div>
                            <p class="text-muted mb-4"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                            <div class="mt-auto">
                                <?php if ($service['title'] === 'Research Help'): ?>
                                    <a href="<?= BASE_URL ?>/contact" class="btn btn-accent">
                                        Schedule Consultation
                                    </a>
                                <?php elseif ($service['title'] === 'E-Library Access'): ?>
                                    <a href="<?= BASE_URL ?>/resources" class="btn btn-accent">
                                        Browse Resources
                                    </a>
                                <?php elseif ($service['title'] === 'Study Spaces'): ?>
                                    <button type="button" class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#bookSpaceModal">
                                        Book a Space
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info shadow-sm">
                    No services are currently available. Please check back later.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Space Booking Modal -->
<div class="modal fade" id="bookSpaceModal" tabindex="-1" aria-labelledby="bookSpaceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookSpaceModalLabel">Book a Study Space</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Please visit the library reception or contact us to book a study space.</p>
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>/contact" class="btn btn-primary">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 100, 0, 1), rgba(0, 100, 0, 1)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
}
</style>