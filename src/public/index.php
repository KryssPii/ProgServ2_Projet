<?php

require_once __DIR__ . '/Classes/Event.php';
require_once __DIR__ . '/Classes/Favorite.php';
require_once __DIR__ . '/Classes/Comment.php';

require_once __DIR__ . '/Interfaces/EventManagerInterface.php';
require_once __DIR__ . '/Interfaces/FavoriteManagerInterface.php';
require_once __DIR__ . '/Interfaces/CommentManagerInterface.php';

require_once __DIR__ . '/Managers/EventManager.php';
require_once __DIR__ . '/Managers/FavoriteManager.php';
require_once __DIR__ . '/Managers/CommentManager.php';

require_once __DIR__ . '/request.php';

$pdo = new PDO(
    'mysql:host=mariadb;port=3306;dbname=my_database;charset=utf8mb4',
    'username',
    'password'
);

$eventManager = new EventManager($pdo);
$favoriteManager = new FavoriteManager($pdo);
$commentManager = new CommentManager($pdo);

$events = [];

foreach ($eventManager->getAll() as $event) {
    $events[] = [
        'ID' => $event->getId(),
        'Titre' => $event->getTitre(),
        'Date' => $event->getDateEvenement(),
        'Ville' => $event->getVille(),
        'Lieu' => $event->getLieu()
    ];
}

$favorites = [];

foreach ($favoriteManager->getByUser(1) as $favorite) {
    $event = $eventManager->getById($favorite->getIdEvent());

    if ($event !== null) {
        $favorites[] = [
            'ID' => $event->getId(),
            'Titre' => $event->getTitre(),
            'Date' => $event->getDateEvenement(),
            'Ville' => $event->getVille(),
            'Lieu' => $event->getLieu()
        ];
    }
}
$comments = [];
foreach ($commentManager->getByEvent(1) as $comment) {
    $comments[] = [
        'ID' => $comment->getId(),
        'Utilisateur' => $comment->getIdUser(),
        'Commentaire' => $comment->getContenu()
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Proximusic</title>
</head>

<body>
    <h1>Proximusic</h1>

    <h2>Événements</h2>
    <?php displayTable($events); ?>

    <h2>Favoris de l’utilisateur 1</h2>
    <?php displayTable($favorites); ?>

    <h2>Commentaires de l’événement 1</h2>
    <?php displayTable($comments); ?>
</body>

</html>
