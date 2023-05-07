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
        $id = filter_input(INPUT_GET, 'id');

        if ($id === false) {
            die(123);
            header('Location: /?sucesso=0');
            return;
        }

        $success = $this->postRepository->remove($id);

        if ($success === false) {
            $_SESSION['mensagem'] = 'Falha ao deletar post';
            header('Location: /');
        } else {
            $_SESSION['mensagem'] = 'Post deletado com sucesso!';
            header('Location: /');
            //header('Location: /');
        }
    }
}