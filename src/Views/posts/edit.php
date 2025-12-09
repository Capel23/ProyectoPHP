<?php $title = 'Editar Post'; ?>

<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-12">
            <h2>Editar Post: <?= htmlspecialchars($post->getTitle()) ?></h2>
            <form method="POST" action="<?= url('/admin/posts/' . $post->getId()) ?>" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="<?= htmlspecialchars($post->getTitle()) ?>" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Contenido</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required><?= htmlspecialchars($post->getContent()) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen (opcional)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif">
                    <div class="form-text">Formatos permitidos: JPG, PNG, GIF (máx. 5MB)</div>
                    <?php if ($post->getImagePath()): ?>
                        <div class="mt-2">
                            <img src="<?= htmlspecialchars($post->getImagePath()) ?>"
                                alt="Imagen actual" class="post-image" style="max-height:150px;">
                            <div class="form-text">Dejar vacío para conservar esta imagen.</div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-warning">Actualizar Post</button>
                <a href="<?= url('/admin/posts') ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>