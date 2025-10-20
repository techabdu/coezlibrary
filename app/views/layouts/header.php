<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= isset($metaDescription) ? $metaDescription : SITE_DESCRIPTION ?>">
    
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/images/favicon.ico">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/theme.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/utilities.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/navigation.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/bootstrap-overrides.css" rel="stylesheet">
    
    <!-- Additional CSS -->
    <?php if (isset($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link href="<?= BASE_URL ?>/public/css/<?= $css ?>.css" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

    <!-- Main Container -->
    <div class="min-vh-100 d-flex flex-column">
        <!-- Navigation -->
        <?php require_once APP_PATH . '/views/layouts/navigation.php'; ?>

        <!-- Flash Messages -->
        <?php if ($flash = $this->getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show m-0" role="alert">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Main Content Area -->
        <main id="main-content" class="flex-grow-1">