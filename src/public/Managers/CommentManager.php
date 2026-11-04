<?php

class CommentManager implements CommentManagerInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(Comment $comment): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO comments (user_id, event_id, content) VALUES (?, ?, ?)'
        );
        $statement->execute([
            $comment->getIdUser(),
            $comment->getIdEvent(),
            $comment->getContenu()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getById(int $id): ?Comment {
        $statement = $this->pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $this->hydrate($row);
    }

    /** @return Comment[] */
    public function getByEvent(int $idEvent): array {
        $statement = $this->pdo->prepare(
            'SELECT * FROM comments WHERE event_id = ? ORDER BY id'
        );
        $statement->execute([$idEvent]);
        $comments = [];

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $comments[] = $this->hydrate($row);
        }

        return $comments;
    }

    public function update(Comment $comment): bool {
        if ($comment->getId() === null) {
            throw new InvalidArgumentException('Un identifiant est requis pour la modification.');
        }

        $statement = $this->pdo->prepare(
            'UPDATE comments SET content = ? WHERE id = ?'
        );

        return $statement->execute([
            $comment->getContenu(),
            $comment->getId()
        ]);
    }

    public function remove(int $id): bool {
        $statement = $this->pdo->prepare('DELETE FROM comments WHERE id = ?');
        $statement->execute([$id]);

        return $statement->rowCount() > 0;
    }

    private function hydrate(array $row): Comment {
        return new Comment(
            (int) $row['id'],
            (int) $row['user_id'],
            (int) $row['event_id'],
            $row['content']
        );
    }
}
