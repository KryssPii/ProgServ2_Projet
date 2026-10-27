<?php

// Utilisateurs

function addUser($pdo, $pseudo, $email, $mdp, $role) {
    $requete = $pdo->prepare('INSERT INTO users (pseudo, email, password, role) VALUES (?, ?, ?, ?)');
    $requete->execute([$pseudo, $email, password_hash($mdp, PASSWORD_DEFAULT), $role]);
}

// Événements

function getEvent($pdo) {
    $requete = $pdo->query('SELECT * FROM events');
    return $requete->fetchAll();
}

function addEvent($pdo, $idArtiste, $titre, $description, $date, $ville, $lieu) {
    $requete = $pdo->prepare('INSERT INTO events (id_role, titre, description, date_evenement, ville, lieu) VALUES (?, ?, ?, ?, ?, ?)');
    $requete->execute([$idArtiste, $titre, $description, $date, $ville, $lieu]);
}

// Favoris

function adFavorite($pdo, $idUser, $idEvent) {
    $requete = $pdo->prepare('INSERT INTO favorites (user_id, event_id) VALUES (?, ?)');
    $requete->execute([$idUser, $idEvent]);
}

function getFavorite($pdo, $idUser) {
    $requete = $pdo->prepare('SELECT events.* FROM favorites JOIN events ON events.id = favorites.event_id WHERE favorites.user_id = ?');
    $requete->execute([$idUser]);
    return $requete->fetchAll();
}

// Commentaires

function addComment($pdo, $idUser, $idEvent, $texte) {
    $requete = $pdo->prepare('INSERT INTO comments (user_id, event_id, content) VALUES (?, ?, ?)');
    $requete->execute([$idUser, $idEvent, $texte]);
}

function getComment($pdo, $idEvent) {
    $requete = $pdo->prepare('SELECT * FROM comments WHERE event_id = ?');
    $requete->execute([$idEvent]);
    return $requete->fetchAll();
}

function displayTable($lignes) {
    if (empty($lignes)) {
        echo '<p>Aucun résultat</p>';
        return;
    }

    echo '<table border="1" cellpadding="5"><tr>';
    foreach (array_keys($lignes[0]) as $colonne) {
        echo '<th>' . htmlspecialchars($colonne) . '</th>';
    }
    echo '</tr>';

    foreach ($lignes as $ligne) {
        echo '<tr>';
        foreach ($ligne as $valeur) {
            echo '<td>' . htmlspecialchars($valeur ?? '') . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
