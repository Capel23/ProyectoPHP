<?php $title = 'Inicio'; ?>
<?php ob_start(); ?>
<div class="row">
    <div class="col-12">
        <h1>Últimos Posts</h1>
        <?php if (empty($posts)): ?>
            <p class="text-muted">No hay posts aún.</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($posts as $post): ?>
                    <a href="/blog/<?= htmlspecialchars($post->getSlug()) ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= htmlspecialchars($post->getTitle()) ?></h5>
                            <small><?= date('d/m/Y', strtotime($post->getPublishedAt())) ?></small>
                        </div>
                        <p class="mb-1"><?= htmlspecialchars(substr(strip_tags($post->getContent()), 0, 150)) ?>...</p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layouts/main.php'; ?>