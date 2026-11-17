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
    <link rel="stylesheet" href="./css/style.css">
</head>
<header class="header">
    <span class="lang">Langue : 🇫🇷</span>

    <a class="logo" href="/">Proximusic</a>
    <a class="btn" href="/login">Se connecter</a>
</header>
<main class="container">
    <section>
        <h2>Nos découvertes de la semaine</h2>
        <div class="discoveries">
            <article class="discovery"><span class="tag">#popmélancolique</span>
                <h3>Faustine</h3>
            </article>
        </div>
    </section>
    <section>
        <h2>Événements à venir</h2>
        <ul class="events">
            <li class="event"><span class="event__name">Leo Middea - Jazz Club, Lausanne</span><time class="event__date">11.12.26</time></li>
        </ul>
    </section>
</main>

</html>
