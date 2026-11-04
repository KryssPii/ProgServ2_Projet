<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($pseudo, $email, $mdp, $role, $bio) {
        $requete = $this->pdo->prepare('INSERT INTO users (pseudo, email, password, role, bio) VALUES (?, ?, ?, ?, ?)');
        $requete->execute([$pseudo, $email, password_hash($mdp, PASSWORD_DEFAULT), $role, $bio]);
        return $this->pdo->lastInsertId();
    }

    public function getAll() {
        $requete = $this->pdo->query('SELECT id, pseudo, email, role, date_creation, bio FROM users');
        return $requete->fetchAll();
    }

    public function getById($id) {
        $requete = $this->pdo->prepare('SELECT id, pseudo, email, role, date_creation, bio FROM users WHERE id = ?');
        $requete->execute([$id]);
        return $requete->fetch();
    }

    public function getByEmail($email) {
        $requete = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $requete->execute([$email]);
        return $requete->fetch();
    }
}

class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // id_role = l'id de l'artiste (users.id)
    public function add($idArtiste, $titre, $description, $date, $ville, $lieu) {
        $requete = $this->pdo->prepare('INSERT INTO events (id_role, titre, description, date_evenement, ville, lieu) VALUES (?, ?, ?, ?, ?, ?)');
        $requete->execute([$idArtiste, $titre, $description, $date, $ville, $lieu]);
        return $this->pdo->lastInsertId();
    }

    public function remove($id) {
        $requete = $this->pdo->prepare('DELETE FROM events WHERE id = ?');
        $requete->execute([$id]);
    }

    public function getAll() {
        $requete = $this->pdo->query('SELECT * FROM events ORDER BY date_evenement');
        return $requete->fetchAll();
    }

    public function getById($id) {
        $requete = $this->pdo->prepare('SELECT * FROM events WHERE id = ?');
        $requete->execute([$id]);
        return $requete->fetch();
    }
}

class Favorite {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($idUser, $idEvent) {
        $requete = $this->pdo->prepare('INSERT INTO favorites (user_id, event_id) VALUES (?, ?)');
        $requete->execute([$idUser, $idEvent]);
    }

    public function remove($idUser, $idEvent) {
        $requete = $this->pdo->prepare('DELETE FROM favorites WHERE user_id = ? AND event_id = ?');
        $requete->execute([$idUser, $idEvent]);
    }

    public function getByUser($idUser) {
        $requete = $this->pdo->prepare('SELECT events.* FROM favorites JOIN events ON events.id = favorites.event_id WHERE favorites.user_id = ?');
        $requete->execute([$idUser]);
        return $requete->fetchAll();
    }
}

class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($idUser, $idEvent, $contenu) {
        $requete = $this->pdo->prepare('INSERT INTO comments (user_id, event_id, content) VALUES (?, ?, ?)');
        $requete->execute([$idUser, $idEvent, $contenu]);
        return $this->pdo->lastInsertId();
    }

    public function getByEvent($idEvent) {
        $requete = $this->pdo->prepare('SELECT * FROM comments WHERE event_id = ?');
        $requete->execute([$idEvent]);
        return $requete->fetchAll();
    }
}
