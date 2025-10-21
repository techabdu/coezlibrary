<?php
/**
 * Databases page view
 * Displays all available external database links
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Research Databases</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Databases</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Databases Grid Section -->
<section class="databases-section py-5">
    <div class="container">
        <?php if (!empty($databases)): ?>
            <!-- Category Filter -->
            <div class="category-filter mb-4">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="h5 mb-0 me-3">Filter by Category:</h2>
                    <div class="nav nav-pills">
                        <button class="nav-link active" data-category="all">All</button>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <button class="nav-link" data-category="<?= htmlspecialchars($category) ?>">
                                    <?= htmlspecialchars($category) ?>
                                </button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Databases Grid -->
            <div class="row g-4">
                <?php foreach ($databases as $database): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-hover">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <?php if (!empty($database['icon_path'])): ?>
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($database['icon_path']) ?>" 
                                             alt="<?= htmlspecialchars($database['name']) ?>" 
                                             class="database-icon me-3"
                                             width="48" height="48">
                                    <?php else: ?>
                                        <div class="database-icon-placeholder me-3">
                                            <i class="bi bi-journal-text fs-3"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="card-title h5 mb-0">
                                        <?= htmlspecialchars($database['name']) ?>
                                    </h3>
                                </div>

                                <?php if (!empty($database['category'])): ?>
                                    <span class="badge bg-light text-dark mb-3">
                                        <?= htmlspecialchars($database['category']) ?>
                                    </span>
                                <?php endif; ?>

                                <p class="card-text mb-3">
                                    <?= htmlspecialchars($database['description']) ?>
                                </p>

                                <a href="<?= htmlspecialchars($database['url']) ?>" 
                                   class="btn btn-primary w-100"
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    Access Database <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                No databases are currently available. Please check back later.
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .hero-section {
    background: linear-gradient(rgba(0, 100, 0, 1), rgba(0, 100, 0, 1)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
    color: white;
}

.shadow-hover {
    transition: box-shadow 0.3s ease-in-out;
}

.shadow-hover:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<!-- Database filtering script -->
<script src="<?= BASE_URL ?>/public/js/databases.js"></script>