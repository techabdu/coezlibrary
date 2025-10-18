<?php
/**
 * Librarian profile page
 * Displays head librarian's information and message
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
        
        <h1 class="display-4">The Librarian</h1>
        <p class="lead text-muted">Meet our head librarian and learn about their vision for the library.</p>
    </div>
</div>

<div class="container py-5">
    <?php if (isset($librarian) && !empty($librarian)): ?>
        <div class="row">
            <!-- Librarian Profile -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card profile-card">
                    <img src="<?= htmlspecialchars($librarian['image_path']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($librarian['name']) ?>">
                    <div class="card-body">
                        <h2 class="h4 card-title"><?= htmlspecialchars($librarian['name']) ?></h2>
                        <p class="card-subtitle mb-3 text-primary"><?= htmlspecialchars($librarian['title']) ?></p>
                        
                        <div class="contact-info">
                            <?php if ($librarian['email']): ?>
                                <p class="mb-2">
                                    <i class="bi bi-envelope me-2"></i>
                                    <a href="mailto:<?= htmlspecialchars($librarian['email']) ?>">
                                        <?= htmlspecialchars($librarian['email']) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($librarian['phone']): ?>
                                <p class="mb-2">
                                    <i class="bi bi-telephone me-2"></i>
                                    <?= htmlspecialchars($librarian['phone']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($librarian['office_hours']): ?>
                                <p class="mb-2">
                                    <i class="bi bi-clock me-2"></i>
                                    <?= htmlspecialchars($librarian['office_hours']) ?>
                                </p>
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