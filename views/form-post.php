<?php
require_once __DIR__ . '/inicio-html.php';
/** @var \ProjetoBlog\Entity\Post|null $post */
?>

    <form method="post">
        <div class="container d-flex flex-column mt-5">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="title" class="form-control" name="title" value="<?= $post !== null ? $post->getTitle() : '' ?>" placeholder="Título do post">
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" name="content" style="height: 100px"><?= $post !== null ? $post->getContent() : '' ?></textarea>
                <label for="content">Conteúdo</label>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>

<?php
require_once __DIR__ . '/fim-html.php';