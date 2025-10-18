<?php
/**
 * College information page
 * Displays college history, mission, vision, and overview
 */
?>

<div class="page-header bg-light">
    <div class="container py-5">
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
        
        <h1 class="display-4">The College</h1>
        <p class="lead text-muted">Learn about our institution's history, mission, and vision.</p>
    </div>
</div>

<div class="container py-5">
    <?php if (isset($sections) && !empty($sections)): ?>
        <!-- Overview Section -->
        <?php foreach ($sections as $section): ?>
            <?php if ($section['section'] === 'overview'): ?>
                <div class="overview-section mb-5">
                    <h2 class="h3 mb-4"><?= htmlspecialchars($section['title']) ?></h2>
                    <div class="lead mb-4">
                        <?= $section['content'] ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="row g-4">
            <!-- Mission Section -->
            <div class="col-md-6">
                <?php foreach ($sections as $section): ?>
                    <?php if ($section['section'] === 'mission'): ?>
                        <div class="card h-100 border-primary mission-card">
                            <div class="card-body">
                                <h2 class="card-title h3 text-primary mb-4">
                                    <i class="bi bi-flag me-2"></i>
                                    <?= htmlspecialchars($section['title']) ?>
                                </h2>
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
                        <div class="card h-100 border-success vision-card">
                            <div class="card-body">
                                <h2 class="card-title h3 text-success mb-4">
                                    <i class="bi bi-eye me-2"></i>
                                    <?= htmlspecialchars($section['title']) ?>
                                </h2>
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
                    <h2 class="h3 mb-4"><?= htmlspecialchars($section['title']) ?></h2>
                    <div class="timeline">
                        <?= $section['content'] ?>
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

<!-- Page Specific Styles -->
<style>
.mission-card, .vision-card {
    transition: transform 0.3s ease;
}

.mission-card:hover, .vision-card:hover {
    transform: translateY(-5px);
}

.timeline {
    position: relative;
    padding: 2rem;
    margin: 0 auto;
    background: var(--light);
    border-radius: var(--border-radius);
}

@media (max-width: 768px) {
    .mission-card, .vision-card {
        margin-bottom: 1rem;
    }
}
</style>