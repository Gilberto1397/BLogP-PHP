<?php

namespace ProjetoBlog\Controller;

use PDO;
use ProjetoBlog\Entity\Post;
use ProjetoBlog\Repository\PostRepository;

class NewPostController implements Controller
{
    public PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function processRequest(): void
    {
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

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            if (stristr($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_', true) . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $post->setImagePath($safeFileName);
            }

        }

        $success = $this->postRepository->add($post);

        if ($success === false) {
            $_SESSION['mensagem'] = 'Falha ao salvar Post';
            header('Location: /');
        } else {
            $_SESSION['mensagem'] = 'Post criado com sucesso';
            header('Location: /');
            //header('Location: /');
        }
    }
}