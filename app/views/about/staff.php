<?php
/**
 * Staff listing page
 * Displays library staff members and their information
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Our Library Staff</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Library Staff</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Staff Section -->
<section class="staff-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Library Organizational Structure</h2>
            <p class="lead text-muted">Our hierarchical structure ensures efficient service delivery and clear lines of responsibility</p>
        </div>

        <!-- College Librarian Level -->
        <div class="organogram-level level-1 mb-5">
            <div class="position-box primary-position mx-auto">
                <div class="position-content">
                    <i class="bi bi-person-workspace display-5 mb-3"></i>
                    <h3 class="h4">College Librarian</h3>
                    <p class="text-muted mb-0">Overall Library Management & Strategic Direction</p>
                </div>
            </div>
        </div>

        <!-- Deputy Librarian Level -->
        <div class="organogram-level level-2 mb-5">
            <div class="position-box secondary-position mx-auto">
                <div class="position-content">
                    <i class="bi bi-person-badge display-5 mb-3"></i>
                    <h3 class="h4">Deputy Librarian</h3>
                    <p class="text-muted mb-0">Operations & Resource Management</p>
                </div>
            </div>
        </div>

        <!-- Department Heads Level -->
        <div class="organogram-level level-3 mb-5">
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div class="position-box tertiary-position">
                        <div class="position-content">
                            <i class="bi bi-book display-5 mb-3"></i>
                            <h4 class="h5">Technical Services</h4>
                            <ul class="list-unstyled small">
                                <li>Acquisitions</li>
                                <li>Cataloguing</li>
                                <li>Classification</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-box tertiary-position">
                        <div class="position-content">
                            <i class="bi bi-people display-5 mb-3"></i>
                            <h4 class="h5">Readers' Services</h4>
                            <ul class="list-unstyled small">
                                <li>Circulation</li>
                                <li>Reference</li>
                                <li>User Education</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-box tertiary-position">
                        <div class="position-content">
                            <i class="bi bi-pc-display display-5 mb-3"></i>
                            <h4 class="h5">Digital Services</h4>
                            <ul class="list-unstyled small">
                                <li>E-Resources</li>
                                <li>Digital Library</li>
                                <li>ICT Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Staff Level -->
        <div class="organogram-level level-4">
            <div class="row justify-content-center g-4">
                <div class="col-md-3">
                    <div class="position-box quaternary-position">
                        <div class="position-content">
                            <i class="bi bi-journal-text display-5 mb-3"></i>
                            <h4 class="h5">Library Officers</h4>
                            <p class="small mb-0">Collection Management & Processing</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="position-box quaternary-position">
                        <div class="position-content">
                            <i class="bi bi-laptop display-5 mb-3"></i>
                            <h4 class="h5">Library Assistants</h4>
                            <p class="small mb-0">User Support & Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="position-box quaternary-position">
                        <div class="position-content">
                            <i class="bi bi-tools display-5 mb-3"></i>
                            <h4 class="h5">Support Staff</h4>
                            <p class="small mb-0">Maintenance & General Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add custom styles for the organogram -->
<style>
.organogram-level {
    margin-bottom: 3rem;
}

.position-box {
    background: white;
    border-radius: 10px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    max-width: 300px;
    margin: 0 auto;
}

.position-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
}

.position-content {
    text-align: center;
}

.primary-position {
    border-left: 5px solid var(--bs-primary);
    background-color: white;
}

.secondary-position {
    border-left: 5px solid var(--bs-success);
    background-color: white;
}

.tertiary-position {
    border-left: 5px solid var(--bs-info);
    background-color: white;
    height: 100%;
}

.quaternary-position {
    border-left: 5px solid var(--bs-warning);
    background-color: white;
    height: 100%;
}

.position-box i {
    color: var(--bs-primary);
}

@media (max-width: 768px) {
    .position-box {
        margin-bottom: 2rem;
    }
    
    .organogram-level {
        margin-bottom: 1rem;
    }
}
</style>

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