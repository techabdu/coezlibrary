<?php
/**
 * View single announcement
 */
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/announcements">Announcements</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($announcement['title']) ?></li>
        </ol>
    </nav>

    <article class="announcement-full">
        <header class="mb-4">
            <h1 class="h2 mb-3"><?= htmlspecialchars($announcement['title']) ?></h1>
            <div class="announcement-meta text-muted">
                <i class="bi bi-calendar3 me-2"></i>
                <?= date('F j, Y', strtotime($announcement['date_posted'])) ?>
            </div>
        </header>

        <div class="announcement-content">
            <?= nl2br(htmlspecialchars($announcement['content'])) ?>
        </div>

        <footer class="mt-5">
            <a href="<?= BASE_URL ?>/announcements" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Back to Announcements
            </a>
        </footer>
    </article>
</div>

<style>
.announcement-full {
    max-width: 800px;
    margin: 0 auto;
}

.announcement-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.announcement-meta {
    font-size: 0.9rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--gray-200);
}

@media (max-width: 768px) {
    .announcement-content {
        font-size: 1rem;
    }
}
</style>