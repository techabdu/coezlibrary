<?php
/**
 * Main Navigation
 * This file contains the main navigation bar that appears on all pages
 */
?>
<header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <!-- Logo/Brand -->
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/">
            <i class="bi bi-book me-2"></i>
            <?= SITE_NAME ?>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" 
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>

                <!-- Resources Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-collection"></i> Resources
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/databases">
                                <i class="bi bi-server"></i> Databases
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/ebooks">
                                <i class="bi bi-tablet"></i> E-Books
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/ejournals">
                                <i class="bi bi-journal-text"></i> E-Journals
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- About Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-info-circle"></i> About
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/about/library">
                                <i class="bi bi-building"></i> The Library
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/about/librarian">
                                <i class="bi bi-person-badge"></i> The Librarian
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/about/staff">
                                <i class="bi bi-people"></i> The Staff
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Services -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/services">
                        <i class="bi bi-gear"></i> Services
                    </a>
                </li>

                <!-- FAQ -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/faq">
                        <i class="bi bi-question-circle"></i> FAQ
                    </a>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/contact">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex" action="<?= BASE_URL ?>/search" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" placeholder="Search resources..." 
                           aria-label="Search" required>
                    <button class="btn btn-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<?php if (isset($breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="bg-light">
    <div class="container">
        <ol class="breadcrumb py-2 mb-0">
            <li class="breadcrumb-item">
                <a href="<?= BASE_URL ?>/">Home</a>
            </li>
            <?php foreach ($breadcrumbs as $label => $url): ?>
                <li class="breadcrumb-item <?= $url ? '' : 'active' ?>" <?= $url ? '' : 'aria-current="page"' ?>>
                    <?php if ($url): ?>
                        <a href="<?= BASE_URL . $url ?>"><?= $label ?></a>
                    <?php else: ?>
                        <?= $label ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
<?php endif; ?>