<?php $title = $post->getTitle(); ?>
<?php ob_start(); ?>
<div class="row">
    <div class="col-12">
        <article>
            <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
            <small class="text-muted">
                Publicado el <?= date('d/m/Y H:i', strtotime($post->getPublishedAt())) ?>
            </small>
            <?php if ($post->getImagePath()): ?>
                <div class="mt-3">
                    <img src="<?= htmlspecialchars($post->getImagePath()) ?>" 
                         alt="<?= htmlspecialchars($post->getTitle()) ?>" 
                         class="post-image">
                </div>
            <?php endif; ?>
            <div class="mt-4">
                <?= nl2br(htmlspecialchars($post->getContent())) ?>
            </div>
        </article>
        <div class="mt-4">
            <a href="/" class="btn btn-outline-secondary">&larr; Volver al blog</a>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>