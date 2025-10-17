<?php
/**
 * Services page view
 * Displays comprehensive list of library services
 */
?>

<!-- Page Header -->
<div class="page-header bg-light">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <?php foreach ($breadcrumbs as $breadcrumb): ?>
                    <li class="breadcrumb-item <?= $breadcrumb['link'] === null ? 'active' : '' ?>">
                        <?php if ($breadcrumb['link']): ?>
                            <a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['title'] ?></a>
                        <?php else: ?>
                            <?= $breadcrumb['title'] ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        
        <h1 class="display-4 mb-3">Our Services</h1>
        <p class="lead text-muted">
            Comprehensive library services designed to support your academic journey
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Services Grid -->
    <div class="row g-4">
        <!-- Research Help -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">Research Assistance</h2>
                    <p>Get expert help with your research needs from our knowledgeable librarians. We offer:</p>
                    <ul class="service-list">
                        <li>One-on-one research consultations</li>
                        <li>Database search strategies</li>
                        <li>Citation management assistance</li>
                        <li>Literature review guidance</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/contact" class="btn btn-outline-primary">
                        Schedule Consultation
                    </a>
                </div>
            </div>
        </div>

        <!-- E-Library Access -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-laptop"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">E-Library Access</h2>
                    <p>Access our digital resources anytime, anywhere:</p>
                    <ul class="service-list">
                        <li>E-books and e-journals</li>
                        <li>Online databases</li>
                        <li>Digital archives</li>
                        <li>Remote access support</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/resources" class="btn btn-outline-primary">
                        Browse Resources
                    </a>
                </div>
            </div>
        </div>

        <!-- Study Spaces -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">Study Spaces</h2>
                    <p>Modern and comfortable spaces for individual and group study:</p>
                    <ul class="service-list">
                        <li>Private study rooms</li>
                        <li>Group discussion areas</li>
                        <li>Quiet reading zones</li>
                        <li>Computer workstations</li>
                    </ul>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookSpaceModal">
                        Book a Space
                    </button>
                </div>
            </div>
        </div>

        <!-- Reference Services -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">Reference Services</h2>
                    <p>Professional guidance for your academic needs:</p>
                    <ul class="service-list">
                        <li>Subject-specific assistance</li>
                        <li>Resource recommendations</li>
                        <li>Research methodology help</li>
                        <li>Academic writing support</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/contact" class="btn btn-outline-primary">
                        Ask a Librarian
                    </a>
                </div>
            </div>
        </div>

        <!-- Interlibrary Loan -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-box-arrow-in-down"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">Interlibrary Loan</h2>
                    <p>Access resources from partner libraries:</p>
                    <ul class="service-list">
                        <li>Book borrowing from other institutions</li>
                        <li>Article delivery service</li>
                        <li>Document scanning</li>
                        <li>International resource sharing</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/interlibrary-loan" class="btn btn-outline-primary">
                        Request Item
                    </a>
                </div>
            </div>
        </div>

        <!-- Technology Support -->
        <div class="col-lg-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-pc-display"></i>
                </div>
                <div class="service-content">
                    <h2 class="h4">Technology Support</h2>
                    <p>Modern tech facilities and assistance:</p>
                    <ul class="service-list">
                        <li>Computer lab access</li>
                        <li>Printing and scanning</li>
                        <li>Wi-Fi connectivity</li>
                        <li>Software tutorials</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/tech-support" class="btn btn-outline-primary">
                        Get Help
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Services Section -->
    <section class="additional-services mt-5">
        <h2 class="h3 mb-4">Additional Services</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mini-service-card">
                    <i class="bi bi-calendar-check"></i>
                    <h3 class="h5">Event Spaces</h3>
                    <p>Book our spaces for academic events and workshops</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-service-card">
                    <i class="bi bi-camera-video"></i>
                    <h3 class="h5">Media Services</h3>
                    <p>Access to multimedia resources and equipment</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-service-card">
                    <i class="bi bi-person-video3"></i>
                    <h3 class="h5">Training Sessions</h3>
                    <p>Regular workshops on library resources and research skills</p>
                </div>
            </div>
        </div>
    </section>
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
                    <a href="tel:<?= htmlspecialchars($libraryInfo['phone'] ?? '') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-telephone me-2"></i>Call Library
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Page Styles -->
<style>
/* Service Cards */
.service-card {
    background: var(--white);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    height: 100%;
    transition: var(--transition-base);
    border: 1px solid var(--gray-200);
    position: relative;
    overflow: hidden;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
}

.service-icon {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1.5rem;
    transition: var(--transition-base);
}

.service-card:hover .service-icon {
    transform: scale(1.1);
}

.service-content h2 {
    margin-bottom: 1rem;
    color: var(--gray-900);
}

.service-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1.5rem;
}

.service-list li {
    position: relative;
    padding-left: 1.75rem;
    margin-bottom: 0.5rem;
    color: var(--gray-700);
}

.service-list li::before {
    content: "→";
    position: absolute;
    left: 0;
    color: var(--primary);
}

/* Mini Service Cards */
.mini-service-card {
    text-align: center;
    padding: 1.5rem;
    background: var(--white);
    border-radius: var(--border-radius-lg);
    transition: var(--transition-base);
    border: 1px solid var(--gray-200);
    height: 100%;
}

.mini-service-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.mini-service-card i {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.mini-service-card h3 {
    margin-bottom: 0.5rem;
    color: var(--gray-900);
}

.mini-service-card p {
    color: var(--gray-700);
    margin-bottom: 0;
    font-size: 0.9rem;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: var(--border-radius-lg);
}

.modal-header {
    border-bottom-color: var(--gray-200);
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .service-card {
        padding: 1.5rem;
    }

    .service-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .service-list li {
        font-size: 0.9rem;
    }

    .mini-service-card {
        padding: 1rem;
    }

    .mini-service-card i {
        font-size: 1.5rem;
    }
}
</style>