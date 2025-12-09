<?php $title = $post->getTitle(); ?>
<?php ob_start(); ?>
<div class="container">
    <article class="bg-white rounded-3 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h1 class="mb-0"><?= htmlspecialchars($post->getTitle()) ?></h1>
            <?php if (\App\Core\SessionManager::isLoggedIn() && $post->getUserId() === \App\Core\SessionManager::getUserId()): ?>
                <div>
                    <a href="/admin/posts/<?= $post->getId() ?>/edit" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-muted mb-4">
            <i class="bi bi-calendar"></i> <?= date('d \d\e F \d\e Y \| H:i', strtotime($post->getPublishedAt())) ?>
        </div>

        <?php if ($post->getImagePath()): ?>
            <div class="mb-4">
                <img src="<?= htmlspecialchars($post->getImagePath()) ?>" 
                     class="img-fluid rounded" 
                     alt="<?= htmlspecialchars($post->getTitle()) ?>">
            </div>
        <?php endif; ?>

        <div class="content">
            <?= nl2br(htmlspecialchars($post->getContent())) ?>
        </div>
    </article>

    <div class="d-flex justify-content-between">
        <a href="/" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al blog
        </a>
        <?php if (\App\Core\SessionManager::isLoggedIn()): ?>
            <a href="/admin/posts/create" class="btn btn-theme text-white">
                <i class="bi bi-journal-plus"></i> Nuevo post
            </a>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>