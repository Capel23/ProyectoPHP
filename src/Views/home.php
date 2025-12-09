<?php $title = 'BlogCap'; ?>

<!-- Hero -->
<section class="hero">
    <div class="container text-center">
        <h1>Bienvenido a BlogCap</h1>
        <p class="lead mt-3">Reflexiones, tutoriales y experiencias en desarrollo web</p>
        <?php if (!\App\Core\SessionManager::isLoggedIn()): ?>
            <a href="<?= url('/register') ?>" class="btn btn-light btn-lg mt-3">
                <i class="bi bi-journal-plus me-2"></i>Crear tu cuenta
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- Posts -->
<div class="container">
    <div class="row">
        <?php if (empty($posts)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-journal-x display-1 text-muted"></i>
                    <h3 class="mt-3">No hay posts aún</h3>
                    <?php if (\App\Core\SessionManager::isLoggedIn()): ?>
                        <a href="<?= url('/admin/posts/create') ?>" class="btn btn-theme text-white mt-3">
                            <i class="bi bi-pencil"></i> Escribe tu primer post
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card post-card h-100">
                        <?php if ($post->getImagePath()): ?>
                            <img src="<?= htmlspecialchars($post->getImagePath()) ?>"
                                class="post-image" alt="<?= htmlspecialchars($post->getTitle()) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($post->getPublishedAt())) ?>
                                <span class="mx-2">•</span>
                                <i class="bi bi-person"></i> <?= htmlspecialchars($post->getAuthorName()) ?>
                            </small>
                            <h5 class="card-title mt-2"><?= htmlspecialchars($post->getTitle()) ?></h5>
                            <p class="card-text flex-grow-1">
                                <?= htmlspecialchars(substr(strip_tags($post->getContent()), 0, 120)) ?>...
                            </p>
                            <a href="<?= url('/blog/' . htmlspecialchars($post->getSlug())) ?>"
                                class="btn btn-outline-primary mt-auto">
                                Leer más <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>