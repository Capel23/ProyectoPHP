<?php $title = 'Administrar Posts'; ?>

<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Posts</h2>
        <a href="<?= url('/admin/posts/create') ?>" class="btn btn-primary">+ Nuevo Post</a>
    </div>

    <?php if (empty($posts)): ?>
        <div class="alert alert-info">No hay posts aún.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= htmlspecialchars($post->getTitle()) ?></td>
                            <td><?= date('d/m/Y', strtotime($post->getPublishedAt())) ?></td>
                            <td>
                                <a href="<?= url('/blog/' . htmlspecialchars($post->getSlug())) ?>"
                                    class="btn btn-sm btn-outline-info" target="_blank">Ver</a>
                                <a href="<?= url('/admin/posts/' . $post->getId() . '/edit') ?>"
                                    class="btn btn-sm btn-outline-warning">Editar</a>
                                <form method="POST" action="<?= url('/admin/posts/' . $post->getId() . '/delete') ?>"
                                    style="display:inline;" onsubmit="return confirm('¿Eliminar?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>