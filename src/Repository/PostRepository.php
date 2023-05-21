<?php

namespace ProjetoBlog\Repository;

use PDO;
use ProjetoBlog\Entity\Post;

class PostRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Post $post): bool
    {
        $sql = 'insert into posts (title, content, image_path) values (:title, :content, :imagePath)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
        $statement->bindValue(':imagePath', $post->getImagePath(), PDO::PARAM_STR);

        $result = $statement->execute();
        $id = $this->pdo->lastInsertId();

        $post->setId((int)$id);
        return $result;
    }

    public function update(Post $post): bool
    {
        $updateImageSql = '';

        if ($post->getImagePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }
        $sql = "update posts set title = :title, content = :content $updateImageSql where id = :id;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
        $statement->bindValue(':id', $post->getId(), PDO::PARAM_INT);

        if ($post->getImagePath() !== null) {
            $statement->bindValue(':image_path', $post->getImagePath());
        }
        $result = $statement->execute();
        $id = $this->pdo->lastInsertId();

        $post->setId((int)$id);
        return $result;
    }

    public function remove(int $id):bool
    {
        $post = $this->find($id);
        $postImage = $post->getImagePath();
        if ($postImage !== null) {
            $deleteImage = "img/uploads/" . $postImage;
            unlink($deleteImage);
        }

        $sql = 'delete from posts where id = :id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
    
    public function all(): array
    {
        $postList = $this->pdo->query('select * from posts;')->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            [static::class, 'hydratePost'],
            $postList
        );
    }

    public function find(int $id): Post
    {
        $statement = $this->pdo->prepare('select * from posts where id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $this->hydratePost($statement->fetch(PDO::FETCH_ASSOC));
    }

    private function hydratePost(array $postData): Post
    {
        $post = new Post($postData['title'], $postData['content']);
        $post->setId($postData['id']);

        if ($postData['image_path'] !== null) {
            $post->setImagePath($postData['image_path']);
        }

        return $post;
    }
}