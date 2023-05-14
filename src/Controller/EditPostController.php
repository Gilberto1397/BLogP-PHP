<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Entity\Post;
use ProjetoBlog\Repository\PostRepository;

class EditPostController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function processRequest(): void
    {
        $id = filter_input(INPUT_GET, 'id');

        if ($id === false) {
            die(123);
            header('Location: /?sucesso=0');
            return;
        }
        $content = filter_input(INPUT_POST, 'content');

        if ($content === false) {
            die(123);
            header('Location: /?sucesso=0');
            return;
        }
        $title = filter_input(INPUT_POST, 'title');

        if ($title === false) {
            die('abc');
            header('Location: /?sucesso=0');
            return;
        }

        $post = new Post($title, $content);
        $post->setId($id);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']
            );
            $post->setImagePath($_FILES['image']['name']);
        }

        $success = $this->postRepository->update($post);

        if ($success === false) {
            $_SESSION['mensagem'] = 'Falha na atualização';
            header('Location: /');
        } else {
            $_SESSION['mensagem'] = 'Atualizado com sucesso!';
            header('Location: /');
            //header('Location: /');
        }

    }
}