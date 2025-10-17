<?php
/**
 * About Us page view
 * Displays library information, mission statement, and staff details
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
        
        <h1 class="display-4 mb-3">About Our Library</h1>
        <p class="lead text-muted">
            Empowering minds through knowledge, innovation, and community engagement.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Mission Statement -->
        <div class="col-lg-8">
            <section class="mission-section mb-5">
                <h2 class="h3 mb-4">Our Mission</h2>
                <?php if (isset($content['content'])): ?>
                    <div class="mission-content">
                        <?= $content['content'] ?>
                    </div>
                <?php else: ?>
                    <div class="mission-content">
                        <p>Our college library is committed to fostering academic excellence by providing comprehensive resources, innovative services, and a conducive learning environment. We strive to:</p>
                        <ul class="mission-list">
                            <li>Support academic achievement and lifelong learning</li>
                            <li>Provide access to diverse and quality information resources</li>
                            <li>Promote information literacy and research skills</li>
                            <li>Create an inclusive and welcoming environment for all users</li>
                            <li>Embrace technological advancements in library services</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Brief History -->
            <section class="history-section mb-5">
                <h2 class="h3 mb-4">Our History</h2>
                <div class="history-content">
                    <div class="history-image mb-4">
                        <img src="<?= BASE_URL ?>/public/images/library-history.jpg" 
                             alt="Library History" 
                             class="img-fluid rounded shadow-sm">
                        <small class="d-block text-muted mt-2">Our library through the years</small>
                    </div>
                    <p>Since our establishment, we have been at the forefront of academic support and resource provision. Our journey reflects our commitment to evolving with educational needs while maintaining our core values of service and excellence.</p>
                </div>
            </section>
        </div>

        <!-- Staff Information -->
        <div class="col-lg-4">
            <aside class="staff-section">
                <h2 class="h3 mb-4">Meet Our Team</h2>
                
                <!-- Head Librarian -->
                <div class="staff-card card mb-4">
                    <img src="<?= BASE_URL ?>/public/images/librarian.jpg" 
                         class="card-img-top" 
                         alt="Head Librarian">
                    <div class="card-body">
                        <h3 class="card-title h5">Sarah Johnson</h3>
                        <p class="card-subtitle mb-2 text-muted">Head Librarian</p>
                        <p class="card-text">With over 15 years of experience in academic libraries, Sarah leads our team with expertise in digital resources and library modernization.</p>
                    </div>
                </div>

                <!-- Library Staff -->
                <div class="staff-grid">
                    <!-- Assistant Librarian -->
                    <div class="staff-card card mb-4">
                        <div class="card-body">
                            <h3 class="card-title h5">Michael Chen</h3>
                            <p class="card-subtitle mb-2 text-muted">Assistant Librarian</p>
                            <p class="card-text">Specializes in research assistance and digital collections.</p>
                        </div>
                    </div>

                    <!-- Technical Services -->
                    <div class="staff-card card mb-4">
                        <div class="card-body">
                            <h3 class="card-title h5">Maria Rodriguez</h3>
                            <p class="card-subtitle mb-2 text-muted">Technical Services</p>
                            <p class="card-text">Manages our digital infrastructure and online resources.</p>
                        </div>
                    </div>

                    <!-- Library Assistant -->
                    <div class="staff-card card">
                        <div class="card-body">
                            <h3 class="card-title h5">James Wilson</h3>
                            <p class="card-subtitle mb-2 text-muted">Library Assistant</p>
                            <p class="card-text">Provides circulation services and student support.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- Stats Section -->
<section class="stats-section bg-light py-5 mt-4">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="stats-item">
                    <div class="stats-icon mb-2">
                        <i class="bi bi-book"></i>
                    </div>
                    <h4 class="h2 mb-1">50,000+</h4>
                    <p class="text-muted mb-0">Books</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-item">
                    <div class="stats-icon mb-2">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <h4 class="h2 mb-1">10,000+</h4>
                    <p class="text-muted mb-0">E-Journals</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-item">
                    <div class="stats-icon mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="h2 mb-1">5,000+</h4>
                    <p class="text-muted mb-0">Active Members</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-item">
                    <div class="stats-icon mb-2">
                        <i class="bi bi-database"></i>
                    </div>
                    <h4 class="h2 mb-1">30+</h4>
                    <p class="text-muted mb-0">Databases</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Page Styles -->
<style>
/* Page Header */
.page-header {
    background-color: var(--light-gray);
    border-bottom: 1px solid var(--gray-200);
}

.page-header h1 {
    color: var(--gray-900);
}

/* Mission Section */
.mission-list {
    list-style: none;
    padding-left: 0;
}

.mission-list li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
}

.mission-list li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--primary);
}

/* Staff Section */
.staff-card {
    transition: var(--transition-base);
    border: none;
    box-shadow: var(--shadow-sm);
}

.staff-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.staff-card .card-img-top {
    height: 200px;
    object-fit: cover;
}

/* Stats Section */
.stats-icon {
    font-size: 2rem;
    color: var(--primary);
}

.stats-item {
    padding: 1.5rem;
}

.stats-item h4 {
    color: var(--gray-900);
    font-weight: 600;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .staff-section {
        margin-top: 2rem;
    }
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .stats-item {
        padding: 1rem;
    }

    .stats-icon {
        font-size: 1.5rem;
    }

    .stats-item h4 {
        font-size: 1.5rem;
    }
}
</style>