<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Repository\PostRepository;

class DeletePostController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function processRequest(): void
    {
        try {
            $sanitizedId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $id = filter_var($sanitizedId, FILTER_VALIDATE_INT);

            if (empty($id)) {
                throw new \InvalidArgumentException('Código de post inválido para apagar post.');
            }

            $this->postRepository->remove($id);

            $_SESSION['mensagem'] = 'Post deletado com sucesso!';
            header('Location: /');
        } catch (\InvalidArgumentException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();
            header('Location: /');
        }
    }
}