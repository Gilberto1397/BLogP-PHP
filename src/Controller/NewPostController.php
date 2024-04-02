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
        try {
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($content)) {
                throw new \InvalidArgumentException('Conteúdo do post inválido.');
            }

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($title)) {
                throw new \InvalidArgumentException('título do post inválido.');
            }

            $post = new Post($title, $content);

            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($_FILES['image']['tmp_name']);

                if (stristr($mimeType, 'image/')) {
                    $safeFileName = uniqid('upload_', true) . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                    $movedImage = move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        __DIR__ . '/../../public/img/uploads/' . $safeFileName
                    );
                    $post->setImagePath($safeFileName);
                }

                if (!$movedImage) {
                    throw new \DomainException('Erro ao salvar imagem do post');
                }
            }

            $this->postRepository->add($post);

            $_SESSION['mensagem'] = 'Post criado com sucesso';
            header('Location: /');
        } catch (\DomainException | \InvalidArgumentException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();
            header('Location: /novo-post');
        }
    }
}