<?php

namespace Comment;

class CommentRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $rows = $this->dbAdapter->query('SELECT * FROM "comment"');
        $comments = [];
        foreach ($rows as $row) {
            $comment = new Comment();
            $comment
                ->setId($row['id'])
                ->setContent($row['content'])
                ->setCreatedAt(new \DateTime($row['created_at']))
                ->setAuthorId($row['author_id'])
                ->setPostId($row['post_id']);
            $comments[] = $comment;
        }
        return $comments;
    }

    //TODO fetch by postId, indice (comme le fetch all avec une clause WHERE)

    public function create(Comment $newComment)
    {
        $query = $this->dbAdapter->prepare(
            'INSERT INTO "comment"(content, created_at, author_id, post_id) 
            VALUES (:content, :created_at, :author_id, :post_id)');
        
        $query->bindValue(':content', $newComment->getContent());
        $query->bindValue(':created_at', $newComment->getCreatedAt());
        $query->bindValue(':author_id', $newComment->getAuthorId());
        $query->bindValue(':post_id', $newComment->getPostId());

        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        $newComment->setId($this->dbAdapter->lastInsertId());
        return $newComment;
    }

    //attention ne gère pas la délétion en cascade
    public function delete(Comment $commentToDelete)
    {
        $query = $this->dbAdapter->prepare('DELETE FROM "comment" WHERE id = :id');
        $query->bindValue(':id', $commentToDelete->getId());
        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        return $result;
    }

    public function deleteByID($idcomment)
    {
        $query = $this->dbAdapter->prepare('DELETE FROM "comment" WHERE post_id = :id');
        $query->bindValue(':id', $idcomment);
        $result = $query->execute();
        if ($result == false) {
            $query->errorInfo();
        }
        return $result;
    }

}