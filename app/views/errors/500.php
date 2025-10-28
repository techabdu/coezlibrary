<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #dc3545;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .error-details {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="error-code">500</div>
            <h1 class="mb-4">Internal Server Error</h1>
            <div class="error-details mb-4">
                <p class="lead text-muted">We apologize, but something went wrong on our end. Our team has been notified and is working to fix the issue.</p>
                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-danger">
                        <pre class="mb-0"><code><?php echo htmlspecialchars($error); ?></code></pre>
                    </div>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-primary">
                    <i class="bi bi-house-door me-2"></i>Return to Homepage
                </a>
                <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-2"></i>Try Again
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>