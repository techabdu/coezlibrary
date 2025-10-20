<?php
/**
 * College information page
 * Displays college history, mission, vision, and overview
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">About Our College</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">About College</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="content-section py-5">
    <div class="container">
        <?php if (isset($sections) && !empty($sections)): ?>
            <!-- Overview Section -->
            <?php foreach ($sections as $section): ?>
                <?php if ($section['section'] === 'overview'): ?>
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h3 text-primary mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                <?= htmlspecialchars($section['title']) ?>
                            </h2>
                            <div class="lead mb-4">
                                <?= $section['content'] ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="row g-4">
                <!-- Mission Section -->
                <div class="col-md-6">
                    <?php foreach ($sections as $section): ?>
                        <?php if ($section['section'] === 'mission'): ?>
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="info-icon me-3">
                                            <i class="bi bi-flag-fill"></i>
                                        </div>
                                        <h2 class="card-title h3 mb-0">
                                            <?= htmlspecialchars($section['title']) ?>
                                        </h2>
                                    </div>
                                    <div class="card-text">
                                        <?= $section['content'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Vision Section -->
                <div class="col-md-6">
                    <?php foreach ($sections as $section): ?>
                        <?php if ($section['section'] === 'vision'): ?>
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="info-icon me-3">
                                            <i class="bi bi-eye-fill"></i>
                                        </div>
                                        <h2 class="card-title h3 mb-0">
                                            <?= htmlspecialchars($section['title']) ?>
                                        </h2>
                                    </div>
                                    <div class="card-text">
                                        <?= $section['content'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- History Section -->
            <div class="history-section mt-5">
                <?php foreach ($sections as $section): ?>
                    <?php if ($section['section'] === 'history'): ?>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="info-icon me-3">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <h2 class="h3 mb-0"><?= htmlspecialchars($section['title']) ?></h2>
                                </div>
                                <div class="timeline">
                                    <?= $section['content'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                College information is currently being updated. Please check back later.
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Page Specific Styles -->
<style>
.hero-section {
    background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
    color: white;
}

.info-icon {
    width: 50px;
    height: 50px;
    background-color: var(--primary-light);
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.timeline {
    position: relative;
    padding: 2rem;
    margin: 0 auto;
    background: var(--light-gray);
    border-radius: var(--border-radius);
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
    }
    
    .hero-section {
        text-align: center;
    }
}
</style>