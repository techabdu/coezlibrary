<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden | <?= SITE_NAME ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .error-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-shield-lock error-icon"></i>
        <div class="error-code">403</div>
        <h1 class="error-message">Access Forbidden</h1>
        <p class="text-muted mb-4">
            You don't have permission to access this page.
            <?php if (!isset($_SESSION['user_id'])): ?>
                Please log in to continue.
            <?php endif; ?>
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?= BASE_URL ?>/admin/login" class="btn btn-primary me-sm-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Log In
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-2"></i>Go to Homepage
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>