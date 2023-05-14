<?php
require_once __DIR__ . '/inicio-html.php';
?>
<?php /** @var \ProjetoBlog\Entity\Post|null $posts */
/** @var \ProjetoBlog\Entity\Post|null $post */
foreach ($posts as $post): ?>
    <div class="list-group container mb-3">
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            <div class="d-flex w-100 justify-content-between mb-1">
                <h5><?= $post->getTitle() ?></h5>
                <small>3 days ago</small>
            </div>
            <p class=""><?= $post->getContent() ?></p>
        </a>
        <a href="/editar-post?id=<?= $post->getId() ?>" class="btn btn-secondary">Editar</a>
        <a href="/deletar-post?id=<?= $post->getId() ?>" class="btn btn-danger">Deletar</a>
    </div>
    <div style="width: 30%;">
        <img src="<?='img/uploads/' . $post->getImagePath() ?>" class="img-thumbnail" alt="" style="height: 300px">
    </div>
<?php endforeach ?>

<?php
require_once __DIR__ . '/fim-html.php';