<?php

class EventManager implements EventManagerInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(Event $event): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO events (id_role, titre, description, date_evenement, ville, lieu) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $statement->execute([
            $event->getIdArtiste(),
            $event->getTitre(),
            $event->getDescription(),
            $event->getDateEvenement(),
            $event->getVille(),
            $event->getLieu()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getById(int $id): ?Event {
        $statement = $this->pdo->prepare('SELECT * FROM events WHERE id = ?');
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $this->hydrate($row);
    }

    /** @return Event[] */
    public function getAll(): array {
        $statement = $this->pdo->query('SELECT * FROM events ORDER BY date_evenement');
        $objects = [];

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $objects[] = $this->hydrate($row);
        }

        return $objects;
    }

    public function update(Event $event): bool {
        if ($event->getId() === null) {
            throw new InvalidArgumentException('Un identifiant est requis pour la modification.');
        }

        $statement = $this->pdo->prepare(
            'UPDATE events SET id_role = ?, titre = ?, description = ?, date_evenement = ?, ville = ?, lieu = ? WHERE id = ?'
        );

        return $statement->execute([
            $event->getIdArtiste(),
            $event->getTitre(),
            $event->getDescription(),
            $event->getDateEvenement(),
            $event->getVille(),
            $event->getLieu(),
            $event->getId()
        ]);
    }

    public function remove(int $id): bool {
        $statement = $this->pdo->prepare('DELETE FROM events WHERE id = ?');
        $statement->execute([$id]);

        return $statement->rowCount() > 0;
    }

    private function hydrate(array $row): Event {
        return new Event(
            (int) $row['id'],
            (int) $row['id_role'],
            $row['titre'],
            $row['description'],
            $row['date_evenement'],
            $row['ville'],
            $row['lieu']
        );
    }
}
