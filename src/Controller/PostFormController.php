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
        $sanitizedId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($sanitizedId, FILTER_VALIDATE_INT);
        $post = null;

        if (!empty($id)) {
            $post = $this->postRepository->find($id);
            $_SESSION['postId'] = $post->getId();
        }
        require_once __DIR__ . '/../../views/form-post.php';
    }
}