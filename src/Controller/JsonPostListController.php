<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Entity\Post;
use ProjetoBlog\Repository\PostRepository;

class JsonPostListController implements Controller
{
    private PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function processRequest(): void
    {
        header('Content-Type: application: application/json');

        $postList = array_map(function (Post $post): array {
            return [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'file_path' => $post->getImagePath() === null ? null : '/img/uploads/' . $post->getImagePath(),
            ];
        }, $this->postRepository->all());

        echo json_encode($postList, JSON_THROW_ON_ERROR);
    }
}