<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Repository\PostRepository;

class PostFormController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function processRequest(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $post = null;

        if (!empty($id)) {
            $post = $this->postRepository->find($id);
        }
        require_once __DIR__ . '/../../views/form-post.php';
    }
}