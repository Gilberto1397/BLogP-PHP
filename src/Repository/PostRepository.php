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
        try {
            $sql = 'insert into posts (title, content, image_path) values (:title, :content, :imagePath);';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
            $statement->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
            $statement->bindValue(':imagePath', $post->getImagePath(), PDO::PARAM_STR);

            $result = $statement->execute();
            $id = $this->pdo->lastInsertId();

            $post->setId((int)$id);
            return $result;
        } catch (\PDOException $exception) {
            $_SESSION['mensagem'] = 'Falha ao salvar post.';
            header('Location: /novo-post');
            die();
        }
    }

    public function update(Post $post): bool
    {
        try {
            $updateImageSql = '';

            if (!empty($post->getImagePath())) {
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
        } catch (\PDOException $exception) {
            $_SESSION['mensagem'] = 'Falha ao atualizar post.';
            header('Location: /novo-post');
            die();
        }
    }

    public function remove(int $id)
    {
        try {
            $post = $this->find($id);
            $postImage = $post->getImagePath();

            $sql = 'delete from posts where id = :id;';
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            if ($postImage !== null) {
                $deleteImage = "img/uploads/" . $postImage;
                $removedImage = unlink($deleteImage);

                if (!$removedImage) {
                    throw new \DomainException('Erro ao apagar imagem de post.');
                }
            }

            $this->pdo->commit();
        } catch (\PDOException | \DomainException $exception) {
            $this->pdo->rollBack();
            $_SESSION['mensagem'] = 'Erro ao apagar post';

            if (is_a($exception, \DomainException::class)) {
                $_SESSION['mensagem'] = $exception->getMessage();
            }
            header('Location: /');
            die();
        }
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
        try {
            $statement = $this->pdo->prepare('select * from posts where id = :id');
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return $this->hydratePost($statement->fetch(PDO::FETCH_ASSOC));
        } catch (\PDOException $exception) {
            $_SESSION['mensagem'] = 'Houve um erro para recuperar o dono desse post.';
            header('Location: /');
            die();
        }
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