<?php
const DB_HOST = '6u2zv5.myd.infomaniak.com';
const DB_PORT = 3306;
const DB_NAME = '6u2zv5_ProgServ2_proximusic';
const DB_USER = '6u2zv5_ProxiAdm';
const DB_PASSWORD = 'Heig2026!';

$dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

require './public/request.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgServ2 Course PHP Template</title>
</head>

<body>
    <h1>ProgServ2 Course PHP Template</h1>

    <h2>Événements</h2>
    <?php displayTable(getEvent($pdo)); ?>

    <h2>Favoris de l'utilisateur 1</h2>
    <?php displayTable(getFavorite($pdo, 1)); ?>

    <h2>Commentaires de l'événement 1</h2>
    <?php displayTable(getComment($pdo, 1)); ?>
</body>

</html>
