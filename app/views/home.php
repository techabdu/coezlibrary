<?php
/**
 * Home page view
 * Displays the main landing page with carousel and other sections
 */
?>

<!-- Hero Section with Carousel -->
<section class="hero-section">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($carouselImages as $index => $image): ?>
                <button type="button" 
                        data-bs-target="#mainCarousel" 
                        data-bs-slide-to="<?= $index ?>" 
                        <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> 
                        aria-label="Slide <?= $index + 1 ?>">
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <?php if (empty($carouselImages)): ?>
                <!-- Default slide when no images are available -->
                <div class="carousel-item active">
                    <img src="<?= BASE_URL ?>/public/images/carousel/default-library.jpg" 
                         class="d-block w-100" 
                         alt="Welcome to <?= SITE_NAME ?>">
                    <div class="carousel-caption">
                        <h2>Welcome to <?= SITE_NAME ?></h2>
                        <p>Your gateway to knowledge and academic resources</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($carouselImages as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($image['image_path']) ?>" 
                             class="d-block w-100" 
                             alt="<?= htmlspecialchars($image['caption']) ?>">
                        <?php if ($image['caption']): ?>
                            <div class="carousel-caption">
                                <h3><?= htmlspecialchars($image['caption']) ?></h3>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Library Information Section -->
<section class="library-info py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Library Information</h2>
        <div class="row g-4">
            <!-- Library Hours -->
            <div class="col-md-4">
                <div class="card h-100 library-info-card">
                    <div class="card-body text-center">
                        <div class="info-icon mb-3">
                            <i class="bi bi-clock text-primary"></i>
                        </div>
                        <h3 class="card-title h4">Library Hours</h3>
                        <?php if (isset($libraryInfo['hours'])): ?>
                            <div class="hours-content">
                                <?= nl2br(htmlspecialchars($libraryInfo['hours'])) ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Hours information not available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="col-md-4">
                <div class="card h-100 library-info-card">
                    <div class="card-body text-center">
                        <div class="info-icon mb-3">
                            <i class="bi bi-geo-alt text-primary"></i>
                        </div>
                        <h3 class="card-title h4">Location</h3>
                        <?php if (isset($libraryInfo['location']) || isset($libraryInfo['address'])): ?>
                            <?php if (isset($libraryInfo['location'])): ?>
                                <p class="mb-2"><?= htmlspecialchars($libraryInfo['location']) ?></p>
                            <?php endif; ?>
                            <?php if (isset($libraryInfo['address'])): ?>
                                <p class="text-muted small">
                                    <?= nl2br(htmlspecialchars($libraryInfo['address'])) ?>
                                </p>
                            <?php endif; ?>
                            <a href="https://maps.google.com/?q=<?= urlencode($libraryInfo['address'] ?? $libraryInfo['location']) ?>" 
                               class="btn btn-outline-primary btn-sm mt-2" 
                               target="_blank">
                                <i class="bi bi-map"></i> View on Map
                            </a>
                        <?php else: ?>
                            <p class="text-muted">Location information not available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="col-md-4">
                <div class="card h-100 library-info-card">
                    <div class="card-body text-center">
                        <div class="info-icon mb-3">
                            <i class="bi bi-headset text-primary"></i>
                        </div>
                        <h3 class="card-title h4">Contact Us</h3>
                        <div class="contact-info">
                            <?php if (isset($libraryInfo['phone'])): ?>
                                <p class="mb-2">
                                    <i class="bi bi-telephone-fill me-2"></i>
                                    <a href="tel:<?= htmlspecialchars($libraryInfo['phone']) ?>" 
                                       class="text-decoration-none">
                                        <?= htmlspecialchars($libraryInfo['phone']) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <?php if (isset($libraryInfo['email'])): ?>
                                <p class="mb-2">
                                    <i class="bi bi-envelope-fill me-2"></i>
                                    <a href="mailto:<?= htmlspecialchars($libraryInfo['email']) ?>" 
                                       class="text-decoration-none">
                                        <?= htmlspecialchars($libraryInfo['email']) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <a href="<?= BASE_URL ?>/contact" class="btn btn-primary mt-3">
                                <i class="bi bi-chat-text-fill me-2"></i>Send Message
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="quick-links py-5">
    <div class="container">
        <h2 class="text-center mb-4">Quick Access</h2>
        <div class="row g-4 justify-content-center">
            <!-- Databases -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/databases" class="quick-link-card card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-server"></i>
                        </div>
                        <h3 class="card-title h4">Research Databases</h3>
                        <p class="card-text text-muted">
                            Access scholarly articles, journals, and research databases
                        </p>
                        <div class="quick-link-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- E-Books -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/ebooks" class="quick-link-card card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-book"></i>
                        </div>
                        <h3 class="card-title h4">E-Books</h3>
                        <p class="card-text text-muted">
                            Browse and download digital books from our collection
                        </p>
                        <div class="quick-link-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- E-Journals -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/ejournals" class="quick-link-card card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h3 class="card-title h4">E-Journals</h3>
                        <p class="card-text text-muted">
                            Access electronic journals and periodicals
                        </p>
                        <div class="quick-link-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- FAQ -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/faq" class="quick-link-card card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <h3 class="card-title h4">FAQ</h3>
                        <p class="card-text text-muted">
                            Find answers to commonly asked questions
                        </p>
                        <div class="quick-link-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Ask a Librarian -->
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/contact" class="quick-link-card card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h3 class="card-title h4">Ask a Librarian</h3>
                        <p class="card-text text-muted">
                            Get help from our library staff
                        </p>
                        <div class="quick-link-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Placeholder for Announcements Section -->
<div id="announcements"></div>

<!-- Add styles for Library Info and Quick Links Sections -->
<style>
/* Library Info Section Styles */
<style>
/* Library Info Section Styles */
.library-info {
    background-color: var(--light-gray) !important;
}

.library-info-card {
    transition: var(--transition-base);
    border: none;
    box-shadow: var(--shadow-sm);
}

.library-info-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.info-icon {
    font-size: 2.5rem;
    height: 80px;
    width: 80px;
    line-height: 80px;
    border-radius: 50%;
    margin: 0 auto;
    background-color: var(--primary-light);
    color: var(--primary);
}

.hours-content {
    white-space: pre-line;
    line-height: 1.6;
}

.contact-info a {
    color: var(--primary);
}

.contact-info a:hover {
    color: var(--primary-dark);
}

/* Responsive adjustments for Library Info */
@media (max-width: 768px) {
    .library-info-card {
        margin-bottom: 1rem;
    }

    .info-icon {
        font-size: 2rem;
        height: 60px;
        width: 60px;
        line-height: 60px;
    }
}

/* Quick Links Section Styles */
.quick-links {
    background-color: var(--white);
}

.quick-link-card {
    transition: var(--transition-base);
    border: 1px solid var(--gray-200);
    position: relative;
    overflow: hidden;
}

.quick-link-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
}

.quick-link-icon {
    font-size: 2rem;
    height: 80px;
    width: 80px;
    line-height: 80px;
    border-radius: 50%;
    margin: 0 auto;
    background-color: var(--primary-light);
    color: var(--primary);
    transition: var(--transition-base);
}

.quick-link-card:hover .quick-link-icon {
    background-color: var(--primary);
    color: var(--white);
    transform: scale(1.1);
}

.quick-link-card .card-title {
    color: var(--gray-900);
    transition: var(--transition-base);
}

.quick-link-card:hover .card-title {
    color: var(--primary);
}

.quick-link-arrow {
    position: absolute;
    right: 1.5rem;
    bottom: 1.5rem;
    opacity: 0;
    transform: translateX(-10px);
    transition: var(--transition-base);
    color: var(--primary);
}

.quick-link-card:hover .quick-link-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Responsive adjustments for Quick Links */
@media (max-width: 992px) {
    .quick-link-card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .quick-link-icon {
        font-size: 1.75rem;
        height: 60px;
        width: 60px;
        line-height: 60px;
    }

    .quick-link-arrow {
        display: none;
    }
}
</style>

<!-- Add custom styles for the carousel -->
<style>
/* Hero Section Styles */
.hero-section {
    margin-top: -1.5rem; /* Compensate for navbar margin */
    margin-bottom: 2rem;
}

/* Carousel Styles */
#mainCarousel {
    background-color: var(--gray-900);
}

#mainCarousel .carousel-item {
    height: 60vh;
    min-height: 400px;
    max-height: 600px;
}

#mainCarousel .carousel-item img {
    object-fit: cover;
    object-position: center;
    height: 100%;
    width: 100%;
}

#mainCarousel .carousel-caption {
    background: rgba(0, 0, 0, 0.6);
    padding: 2rem;
    border-radius: var(--border-radius-lg);
    max-width: 80%;
    margin: 0 auto;
    bottom: 2rem;
}

#mainCarousel .carousel-caption h2,
#mainCarousel .carousel-caption h3 {
    color: var(--white);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

#mainCarousel .carousel-caption p {
    color: var(--gray-200);
    margin-bottom: 0;
    font-size: 1.1rem;
}

/* Carousel Controls */
#mainCarousel .carousel-control-prev,
#mainCarousel .carousel-control-next {
    width: 5%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#mainCarousel:hover .carousel-control-prev,
#mainCarousel:hover .carousel-control-next {
    opacity: 0.8;
}

#mainCarousel .carousel-indicators {
    margin-bottom: 1rem;
}

#mainCarousel .carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 6px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #mainCarousel .carousel-item {
        height: 50vh;
        min-height: 300px;
    }

    #mainCarousel .carousel-caption {
        padding: 1rem;
        bottom: 1rem;
    }

    #mainCarousel .carousel-caption h2,
    #mainCarousel .carousel-caption h3 {
        font-size: 1.5rem;
    }

    #mainCarousel .carousel-caption p {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    #mainCarousel .carousel-item {
        height: 40vh;
        min-height: 250px;
    }

    #mainCarousel .carousel-caption {
        padding: 0.75rem;
        bottom: 0.5rem;
    }
}
</style>