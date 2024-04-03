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
        try {
            $id = $_SESSION['postId'];
            if (empty($id)) {
                throw new \InvalidArgumentException('Código de post inválido para vinculação ao post.');
            }

            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($content)) {
                throw new \InvalidArgumentException('Conteúdo do post inválido.');
            }

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($title)) {
                throw new \InvalidArgumentException('Título do post inválido');
            }

            $post = new Post($title, $content);
            $post->setId($id);

//            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) { //ARRUMAR ISSO
//                $movedImage = move_uploaded_file(
//                    $_FILES['image']['tmp_name'],
//                    __DIR__.'/../../public/img/uploads/'.$_FILES['image']['name']
//                );
//                $post->setImagePath($_FILES['image']['name']);
//            }
//
//            if (!$movedImage) {
//                throw new \DomainException('Erro ao atualizar imagem do post.');
//            }

            $this->postRepository->update($post);

            $_SESSION['mensagem'] = 'Atualizado com sucesso!';
            header('Location: /');
        } catch (\DomainException|\InvalidArgumentException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();
            header("Location: /editar-post?id={$id}");
        }
    }
}