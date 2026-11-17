<?php
$erreur = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $motDePasse = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $motDePasse === "") {
        $erreur = "Adresse e-mail ou mot de passe incorrect.";
    } else {
        $pdo = new PDO(
            "mysql:host=mariadb;port=3306;dbname=my_database;charset=utf8mb4",
            "username",
            "password"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête préparée : protège contre l'injection SQL
        $sql = "SELECT id, pseudo, password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe haché
        if ($user && password_verify($motDePasse, $user["password"])) {
            $message = "Connexion réussie. Bonjour " . $user["pseudo"] . " !";
        } else {
            $erreur = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - Proximusic</title>
</head>

<body>
    <h1>Connexion</h1>

    <?php if ($erreur !== "") { ?>
        <p><?= htmlspecialchars($erreur) ?></p>
    <?php } ?>

    <?php if ($message !== "") { ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php } ?>

    <form action="connexion.php" method="POST">
        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" maxlength="100" required>

        <br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p><a href="inscription.php">Pas de compte ? S'inscrire</a></p>
</body>

</html>
