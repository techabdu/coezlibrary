<?php
/**
 * Staff listing page
 * Displays library staff members and their information
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Our Library Staff</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Library Staff</li>
                    </ol>
                </nav>
                <p class="lead mb-0 opacity-75">Meet the dedicated team behind our library services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Staff Section -->
<section class="staff-section py-5">
    <div class="container">
        <?php if (!empty($staff)): ?>
            <div class="row g-4">
                <?php foreach ($staff as $member): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card staff-card border-0 shadow-sm h-100">
                            <?php if ($member->image_path): ?>
                                <div class="card-img-container">
                                    <img src="<?= htmlspecialchars($member->image_path) ?>" 
                                         class="card-img-top staff-image" 
                                         alt="<?= htmlspecialchars($member->name) ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body p-4">
                                <h2 class="h5 card-title mb-1"><?= htmlspecialchars($member->name) ?></h2>
                                <p class="card-subtitle mb-3 text-primary fw-medium">
                                    <?= htmlspecialchars($member->position) ?>
                                </p>
                                
                                <?php if (!empty($member->department)): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="info-icon-sm me-3">
                                            <i class="bi bi-diagram-2-fill"></i>
                                        </div>
                                        <span><?= htmlspecialchars($member->department) ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($member->bio)): ?>
                                    <p class="card-text mb-4">
                                        <?= htmlspecialchars($member->bio) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="contact-info mt-auto">
                                    <?php if (!empty($member->email)): ?>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="info-icon-sm me-3">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <a href="mailto:<?= htmlspecialchars($member->email) ?>" 
                                               class="text-decoration-none">
                                                <?= htmlspecialchars($member->email) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($member->phone)): ?>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="info-icon-sm me-3">
                                                <i class="bi bi-telephone-fill"></i>
                                            </div>
                                            <span><?= htmlspecialchars($member->phone) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($member->office_hours)): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon-sm me-3">
                                                <i class="bi bi-clock-fill"></i>
                                            </div>
                                            <span><?= htmlspecialchars($member->office_hours) ?></span>
                                        </div>
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
</section>

<!-- Page Specific Styles -->
<style>
.hero-section {
    background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
}

.staff-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.staff-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.card-img-container {
    height: 250px;
    overflow: hidden;
}

.staff-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.staff-card:hover .staff-image {
    transform: scale(1.05);
}

.info-icon-sm {
    width: 35px;
    height: 35px;
    background-color: var(--primary-light);
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

@media (max-width: 992px) {
    .card-img-container {
        height: 200px;
    }
    
    .hero-section {
        text-align: center;
    }
}
</style>