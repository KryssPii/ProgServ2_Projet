<?php

class FavoriteManager implements FavoriteManagerInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(Favorite $favorite): bool {
        $statement = $this->pdo->prepare(
            'INSERT INTO favorites (user_id, event_id) VALUES (?, ?)'
        );

        return $statement->execute([
            $favorite->getIdUser(),
            $favorite->getIdEvent()
        ]);
    }

    public function exists(int $idUser, int $idEvent): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1 FROM favorites WHERE user_id = ? AND event_id = ?'
        );
        $statement->execute([$idUser, $idEvent]);

        return $statement->fetchColumn() !== false;
    }

    /** @return Favorite[] */
    public function getByUser(int $idUser): array {
        $statement = $this->pdo->prepare(
            'SELECT user_id, event_id FROM favorites WHERE user_id = ? ORDER BY event_id'
        );
        $statement->execute([$idUser]);
        $favorites = [];

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $favorites[] = new Favorite((int) $row['user_id'], (int) $row['event_id']);
        }

        return $favorites;
    }

    public function remove(int $idUser, int $idEvent): bool {
        $statement = $this->pdo->prepare(
            'DELETE FROM favorites WHERE user_id = ? AND event_id = ?'
        );
        $statement->execute([$idUser, $idEvent]);

        return $statement->rowCount() > 0;
    }
}
