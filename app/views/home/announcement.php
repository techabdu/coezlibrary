<?php
/**
 * Single announcement view
 */
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Announcement</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <article class="card announcement-full">
                <div class="card-body">
                    <!-- Announcement Header -->
                    <div class="announcement-header mb-4">
                        <h1 class="card-title h2 mb-3">
                            <?= htmlspecialchars($announcement['title']) ?>
                        </h1>
                        <div class="announcement-meta text-muted">
                            <i class="bi bi-calendar3 me-2"></i>
                            <?= date('F j, Y', strtotime($announcement['date_posted'])) ?>
                        </div>
                    </div>

                    <!-- Announcement Content -->
                    <div class="announcement-content">
                        <?= nl2br(htmlspecialchars($announcement['content'])) ?>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4 pt-3 border-top">
                        <a href="<?= BASE_URL ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<style>
.announcement-full {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: none;
}

.announcement-header {
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 1rem;
}

.announcement-content {
    line-height: 1.8;
    font-size: 1.1rem;
    color: var(--gray-800);
}

.announcement-meta {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .announcement-content {
        font-size: 1rem;
        line-height: 1.6;
    }
}
</style>