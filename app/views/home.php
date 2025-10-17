<?php
/**
 * Home page view
 * Displays the main landing page with carousel and other sections
 */
?>

<!-- Hero Section with Carousel -->
<section class="hero-section">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($carouselImages as $index => $image): ?>
                <button type="button" 
                        data-bs-target="#mainCarousel" 
                        data-bs-slide-to="<?= $index ?>" 
                        <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> 
                        aria-label="Slide <?= $index + 1 ?>">
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <?php if (empty($carouselImages)): ?>
                <!-- Default slide when no images are available -->
                <div class="carousel-item active">
                    <img src="<?= BASE_URL ?>/public/images/carousel/default-library.jpg" 
                         class="d-block w-100" 
                         alt="Welcome to <?= SITE_NAME ?>">
                    <div class="carousel-caption">
                        <h2>Welcome to <?= SITE_NAME ?></h2>
                        <p>Your gateway to knowledge and academic resources</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($carouselImages as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($image['image_path']) ?>" 
                             class="d-block w-100" 
                             alt="<?= htmlspecialchars($image['caption']) ?>">
                        <?php if ($image['caption']): ?>
                            <div class="carousel-caption">
                                <h3><?= htmlspecialchars($image['caption']) ?></h3>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Placeholder for Library Info Section -->
<div id="library-info"></div>

<!-- Placeholder for Quick Links Section -->
<div id="quick-links"></div>

<!-- Placeholder for Announcements Section -->
<div id="announcements"></div>

<!-- Add custom styles for the carousel -->
<style>
/* Hero Section Styles */
.hero-section {
    margin-top: -1.5rem; /* Compensate for navbar margin */
    margin-bottom: 2rem;
}

/* Carousel Styles */
#mainCarousel {
    background-color: var(--gray-900);
}

#mainCarousel .carousel-item {
    height: 60vh;
    min-height: 400px;
    max-height: 600px;
}

#mainCarousel .carousel-item img {
    object-fit: cover;
    object-position: center;
    height: 100%;
    width: 100%;
}

#mainCarousel .carousel-caption {
    background: rgba(0, 0, 0, 0.6);
    padding: 2rem;
    border-radius: var(--border-radius-lg);
    max-width: 80%;
    margin: 0 auto;
    bottom: 2rem;
}

#mainCarousel .carousel-caption h2,
#mainCarousel .carousel-caption h3 {
    color: var(--white);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

#mainCarousel .carousel-caption p {
    color: var(--gray-200);
    margin-bottom: 0;
    font-size: 1.1rem;
}

/* Carousel Controls */
#mainCarousel .carousel-control-prev,
#mainCarousel .carousel-control-next {
    width: 5%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#mainCarousel:hover .carousel-control-prev,
#mainCarousel:hover .carousel-control-next {
    opacity: 0.8;
}

#mainCarousel .carousel-indicators {
    margin-bottom: 1rem;
}

#mainCarousel .carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 6px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #mainCarousel .carousel-item {
        height: 50vh;
        min-height: 300px;
    }

    #mainCarousel .carousel-caption {
        padding: 1rem;
        bottom: 1rem;
    }

    #mainCarousel .carousel-caption h2,
    #mainCarousel .carousel-caption h3 {
        font-size: 1.5rem;
    }

    #mainCarousel .carousel-caption p {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    #mainCarousel .carousel-item {
        height: 40vh;
        min-height: 250px;
    }

    #mainCarousel .carousel-caption {
        padding: 0.75rem;
        bottom: 0.5rem;
    }
}
</style>