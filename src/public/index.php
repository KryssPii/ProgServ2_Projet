<?php
const DB_HOST = 'mariadb';
const DB_PORT = 3306;
/*
const DB_NAME = '6u2zv5_ProgServ2_proximusic';
const DB_USER = '6u2zv5_ProxiAdm';
*/
const DB_NAME = 'my_database';
const DB_USER = 'username';
const DB_PASSWORD = 'password';

$dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

require __DIR__ . '/class.php';
require __DIR__ . '/request.php';
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
