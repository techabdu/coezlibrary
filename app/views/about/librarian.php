<?php
/**
 * Librarian profile page
 * Displays head librarian's information and message
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Meet Our Librarian</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Head Librarian</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="content-section py-5">
    <div class="container">
        <?php if (isset($librarian) && !empty($librarian)): ?>
            <div class="row g-4">
                <!-- Librarian Profile -->
                <div class="col-lg-4">
                    <div class="card profile-card border-0 shadow-sm h-100">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars($librarian['image_path']) ?>" 
                                 class="card-img-top profile-image" 
                                 alt="<?= htmlspecialchars($librarian['name']) ?>">
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h2 class="h3 card-title mb-1"><?= htmlspecialchars($librarian['name']) ?></h2>
                                <p class="card-subtitle text-primary"><?= htmlspecialchars($librarian['title']) ?></p>
                            </div>
                            
                            <div class="contact-info">
                                <?php if ($librarian['email']): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="info-icon-sm me-3">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <a href="mailto:<?= htmlspecialchars($librarian['email']) ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($librarian['email']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($librarian['phone']): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="info-icon-sm me-3">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                        <span><?= htmlspecialchars($librarian['phone']) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($librarian['office_hours']): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="info-icon-sm me-3">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <span><?= htmlspecialchars($librarian['office_hours']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                        <?php if (isset($social_links) && !empty($social_links)): ?>
                            <div class="social-links mt-3">
                                <?php foreach ($social_links as $platform => $url): ?>
                                    <a href="<?= htmlspecialchars($url) ?>" 
                                       class="btn btn-outline-primary btn-sm me-2" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <i class="bi bi-<?= $platform ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Librarian Information -->
            <div class="col-lg-8">
                <!-- Qualifications -->
                <div class="qualifications-section mb-4">
                    <h3 class="h4 mb-3">Qualifications</h3>
                    <div class="card">
                        <div class="card-body">
                            <?php 
                            $qualifications = explode("\n", $librarian['qualification']);
                            foreach ($qualifications as $qualification): ?>
                                <div class="qualification-item mb-2">
                                    <i class="bi bi-mortarboard me-2 text-primary"></i>
                                    <?= htmlspecialchars($qualification) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div class="message-section">
                    <h3 class="h4 mb-3">Message from the Librarian</h3>
                    <div class="card">
                        <div class="card-body">
                            <blockquote class="blockquote">
                                <?= $librarian['message'] ?>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Librarian information is currently being updated. Please check back later.
        </div>
    <?php endif; ?>
</div>

<!-- Page Specific Styles -->
<style>
.profile-card {
    border: none;
    box-shadow: var(--shadow-sm);
}

.profile-card img {
    height: 300px;
    object-fit: cover;
}

.qualification-item {
    padding: 0.5rem;
    border-radius: var(--border-radius);
    background-color: var(--light);
}

.blockquote {
    font-size: 1.1rem;
    font-style: italic;
    position: relative;
    padding: 1rem 2rem;
}

.blockquote::before {
    content: '"';
    font-size: 4rem;
    position: absolute;
    left: -1rem;
    top: -1rem;
    opacity: 0.1;
}

@media (max-width: 992px) {
    .profile-card img {
        height: 250px;
    }
}
</style>