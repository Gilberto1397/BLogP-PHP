<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Entity\Post;
use ProjetoBlog\Repository\PostRepository;

class NewJsonPostController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function processRequest(): void
    {
        $request = file_get_contents('php://input');
        //var_dump($request); die();
        $postData = json_decode($request, true);
        $post = new Post($postData['title'], $postData['content']);
        $this->postRepository->add($post);

        http_response_code(201);
    }
}