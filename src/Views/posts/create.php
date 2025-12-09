<?php $title = 'Crear Post'; ?>
<?php ob_start(); ?>
<div class="row">
    <div class="col-12">
        <h2>Crear Nuevo Post</h2>
        <form method="POST" action="/admin/posts" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required maxlength="255">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenido</label>
                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagen (opcional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif">
                <div class="form-text">Formatos permitidos: JPG, PNG, GIF (máx. 5MB)</div>
            </div>
            <button type="submit" class="btn btn-success">Crear Post</button>
            <a href="/admin/posts" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>