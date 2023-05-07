<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Repository\PostRepository;

class PostListController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function processRequest(): void
    {
       $posts = $this->postRepository->all();
       $message = null;

       if (!empty($_SESSION['mensagem'])) {
           $message = $_SESSION['mensagem'];
           unset($_SESSION['mensagem']);
       }
        require_once __DIR__ . '/../../views/posts.php';
    }
}