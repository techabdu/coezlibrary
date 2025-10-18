<?php
/**
 * Staff listing page
 * Displays library staff members and their information
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
        
        <h1 class="display-4">Our Staff</h1>
        <p class="lead text-muted">Meet the dedicated team behind our library services.</p>
    </div>
</div>

<div class="container py-5">
    <?php if (isset($staff) && !empty($staff)): ?>
        <div class="row g-4">
            <?php foreach ($staff as $member): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card staff-card h-100">
                        <?php if ($member['image_path']): ?>
                            <img src="<?= htmlspecialchars($member['image_path']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($member['name']) ?>">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h2 class="h5 card-title"><?= htmlspecialchars($member['name']) ?></h2>
                            <p class="card-subtitle mb-2 text-primary">
                                <?= htmlspecialchars($member['position']) ?>
                            </p>
                            
                            <?php if ($member['department']): ?>
                                <p class="department mb-3">
                                    <i class="bi bi-diagram-2 me-2"></i>
                                    <?= htmlspecialchars($member['department']) ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($member['bio']): ?>
                                <p class="card-text">
                                    <?= htmlspecialchars($member['bio']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="contact-info">
                                <?php if ($member['email']): ?>
                                    <p class="mb-2">
                                        <i class="bi bi-envelope me-2"></i>
                                        <a href="mailto:<?= htmlspecialchars($member['email']) ?>">
                                            <?= htmlspecialchars($member['email']) ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($member['phone']): ?>
                                    <p class="mb-2">
                                        <i class="bi bi-telephone me-2"></i>
                                        <?= htmlspecialchars($member['phone']) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($member['office_hours']): ?>
                                    <p class="mb-0">
                                        <i class="bi bi-clock me-2"></i>
                                        <?= htmlspecialchars($member['office_hours']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Staff information is currently being updated. Please check back later.
        </div>
    <?php endif; ?>
</div>

<!-- Page Specific Styles -->
<style>
.staff-card {
    transition: transform 0.3s ease;
    border: none;
    box-shadow: var(--shadow-sm);
}

.staff-card:hover {
    transform: translateY(-5px);
}

.staff-card img {
    height: 250px;
    object-fit: cover;
}

.staff-card .card-footer {
    border-top: 1px solid var(--gray-200);
}

.department {
    font-size: 0.9rem;
    color: var(--gray-600);
}

@media (max-width: 768px) {
    .staff-card img {
        height: 200px;
    }
}
</style>