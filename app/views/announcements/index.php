<?php
/**
 * View all announcements
 */
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Announcements</li>
        </ol>
    </nav>

    <h1 class="mb-4">News & Announcements</h1>

    <?php if (empty($announcements)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            No announcements available at this time.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($announcements as $announcement): ?>
                <div class="col-lg-6">
                    <article class="card h-100 announcement-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="announcement-date">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    <?= date('F j, Y', strtotime($announcement['date_posted'])) ?>
                                </div>
                            </div>
                            
                            <h2 class="card-title h5">
                                <?= htmlspecialchars($announcement['title']) ?>
                            </h2>
                            
                            <div class="card-text announcement-excerpt mb-3">
                                <?= htmlspecialchars(
                                    strlen($announcement['content']) > 200 
                                        ? substr($announcement['content'], 0, 197) . '...' 
                                        : $announcement['content']
                                ) ?>
                            </div>
                            <button type="button" 
                                    class="btn btn-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#announcementModal-<?= $announcement['id'] ?>">
                                Read Full Announcement <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                            
                           
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.announcement-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.announcement-date {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.announcement-excerpt {
    color: var(--text-color);
    line-height: 1.6;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
}

@media (max-width: 768px) {
    .announcement-excerpt {
        -webkit-line-clamp: 3;
    }
}

/* Modal styles */
.announcement-modal .modal-header {
    border-bottom: 2px solid var(--primary-color);
}

.announcement-modal .announcement-date {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--gray-200);
}

.announcement-modal .announcement-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

@media (max-width: 768px) {
    .announcement-modal .announcement-content {
        font-size: 1rem;
        line-height: 1.6;
    }
}
</style>

<!-- Announcement Modals -->
<?php foreach ($announcements as $announcement): ?>
<div class="modal fade announcement-modal" 
     id="announcementModal-<?= $announcement['id'] ?>" 
     tabindex="-1" 
     aria-labelledby="announcementModalLabel-<?= $announcement['id'] ?>" 
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel-<?= $announcement['id'] ?>">
                    <?= htmlspecialchars($announcement['title']) ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="announcement-date">
                    <i class="bi bi-calendar3 me-2"></i>
                    <?= date('F j, Y', strtotime($announcement['date_posted'])) ?>
                </div>
                <div class="announcement-content">
                    <?= nl2br(htmlspecialchars($announcement['content'])) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>