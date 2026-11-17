<?php

class UserManager implements UserManagerInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(User $user): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO users (pseudo, email, password, role, bio) VALUES (?, ?, ?, ?, ?)'
        );
        $statement->execute([
            $user->getPseudo(),
            $user->getEmail(),
            $user->getPasswordHash(),
            $user->getRole(),
            $user->getBio()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getById(int $id): ?User {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $this->hydrate($row);
    }

    public function getByEmail(string $email): ?User {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $statement->execute([$email]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $this->hydrate($row);
    }

    /** @return User[] */
    public function getAll(): array {
        $statement = $this->pdo->query('SELECT * FROM users ORDER BY id');
        $objects = [];

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $objects[] = $this->hydrate($row);
        }

        return $objects;
    }

    public function update(User $user): bool {
        if ($user->getId() === null) {
            throw new InvalidArgumentException('Un identifiant est requis pour la modification.');
        }

        $statement = $this->pdo->prepare(
            'UPDATE users SET pseudo = ?, email = ?, password = ?, role = ?, bio = ? WHERE id = ?'
        );

        return $statement->execute([
            $user->getPseudo(),
            $user->getEmail(),
            $user->getPasswordHash(),
            $user->getRole(),
            $user->getBio(),
            $user->getId()
        ]);
    }

    public function remove(int $id): bool {
        $statement = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $statement->execute([$id]);

        return $statement->rowCount() > 0;
    }

    private function hydrate(array $row): User {
        return new User(
            (int) $row['id'],
            $row['pseudo'],
            $row['email'],
            $row['password'],
            $row['role'],
            $row['bio']
        );
    }
}
