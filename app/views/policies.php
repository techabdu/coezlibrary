<?php
/**
 * Library policies page
 * Displays all library policies organized by category
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Library Policies</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Policies</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-5">
    <!-- Policies Accordion -->
    <div class="row">
        <div class="col-lg-12">
            <?php if (!empty($categories)): ?>
                <div class="accordion" id="policiesAccordion">
                    <?php foreach ($categories as $categoryIndex => $category): ?>
                        <?php if (isset($policies[$category])): ?>
                            <div class="accordion-item shadow-sm mb-3 border">
                                <h2 class="accordion-header" id="heading<?= $categoryIndex ?>">
                                    <button class="accordion-button <?= $categoryIndex !== 0 ? 'collapsed' : '' ?>" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse<?= $categoryIndex ?>" 
                                            aria-expanded="<?= $categoryIndex === 0 ? 'true' : 'false' ?>" 
                                            aria-controls="collapse<?= $categoryIndex ?>">
                                        <span class="h5 mb-0"><?= htmlspecialchars(ucwords($category)) ?></span>
                                    </button>
                                </h2>
                                <div id="collapse<?= $categoryIndex ?>" 
                                     class="accordion-collapse collapse <?= $categoryIndex === 0 ? 'show' : '' ?>" 
                                     aria-labelledby="heading<?= $categoryIndex ?>" 
                                     data-bs-parent="#policiesAccordion">
                                    <div class="accordion-body">
                                        <?php foreach ($policies[$category] as $policy): ?>
                                            <div class="policy-item mb-4">
                                                <h3 class="h5 mb-3"><?= htmlspecialchars($policy['title']) ?></h3>
                                                <div class="policy-content">
                                                    <?= nl2br(htmlspecialchars($policy['content'])) ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info shadow-sm">
                    No policies are currently available. Please check back later.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 100, 0, 1), rgba(0, 100, 0, 1)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
}

.policy-content {
    color: var(--text-muted);
    line-height: 1.6;
}

.accordion-button:not(.collapsed) {
    background-color: var(--light-gray);
    color: var(--primary-color);
}

.accordion-button:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 100, 0, 0.25);
}
</style>