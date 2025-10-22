<?php
/**
 * Admin login page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: var(--bs-primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .btn-login {
            padding: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-4">
            <h1 class="h3"><?= SITE_NAME ?></h1>
            <p class="text-muted">Admin Panel</p>
        </div>

        <div class="card">
            <div class="card-header text-center">
                <h2 class="h4 mb-0">Login</h2>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/admin/authenticate" method="POST" class="needs-validation" novalidate>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Username" required autofocus>
                        <label for="username">Username</label>
                        <div class="invalid-feedback">
                            Please enter your username.
                        </div>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">Password</label>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>

                    <button class="w-100 btn btn-primary btn-login" type="submit">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Form Validation Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    </script>
</body>
</html>