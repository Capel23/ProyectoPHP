<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'BlogCap') ?></title>
    <!-- Bootstrap 5.3 + Icons  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-body-font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --bs-heading-font-family: 'DM Serif Display', serif;
        }

        body {
            background-color: #fafafa;
        }

        .navbar-brand {
            font-family: var(--bs-heading-font-family) !important;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1.5rem 1.5rem;
        }

        .hero h1 {
            font-family: var(--bs-heading-font-family);
            font-weight: 600;
            font-size: 2.8rem;
        }

        .post-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .post-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .btn-theme {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
        }

        .btn-theme:hover {
            opacity: 0.9;
        }

        .content {
            line-height: 1.7;
            font-size: 1.05rem;
        }

        .content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100"> 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-journal-text me-2"></i>BlogCap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Inicio</a>
                    </li>
                    <?php if (\App\Core\SessionManager::isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/posts">
                                <i class="bi bi-pencil-square"></i> Admin
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                👋 <?= htmlspecialchars($_SESSION['username']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Salir</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-theme text-white ms-2" href="/register">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>

    <main class="flex-grow-1">
        <?= $content ?? '' ?>
    </main>

    <footer class="mt-auto py-3 bg-light border-top">
        <div class="container text-center text-muted small">
            © <?= date('Y') ?> BlogCap. Proyecto PHP - CMS.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>