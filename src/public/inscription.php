<?php
$erreur = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pseudo = trim($_POST["pseudo"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $motDePasse = $_POST["password"] ?? "";

    // Validation
    if ($pseudo === "" || strlen($pseudo) > 25) {
        $erreur = "Le pseudo est obligatoire (25 caractères maximum).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $erreur = "L'adresse e-mail n'est pas valide.";
    } elseif (strlen($motDePasse) < 8) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $pdo = new PDO(
            "mysql:host=mariadb;port=3306;dbname=my_database;charset=utf8mb4",
            "username",
            "password"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hachage du mot de passe
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);

        try {
            // Requête préparée : protège contre l'injection SQL
            $sql = "INSERT INTO users (pseudo, email, password)
                    VALUES (:pseudo, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pseudo", $pseudo);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":password", $hash);
            $stmt->execute();

            $message = "Compte créé. Tu peux te connecter.";
        } catch (PDOException $e) {
            // Pseudo ou e-mail déjà utilisé (colonnes UNIQUE)
            $erreur = "Ce pseudo ou cette adresse e-mail est déjà utilisé.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription - Proximusic</title>
</head>

<body>
    <h1>Inscription</h1>

    <?php if ($erreur !== "") { ?>
        <p><?= htmlspecialchars($erreur) ?></p>
    <?php } ?>

    <?php if ($message !== "") { ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php } ?>

    <form action="inscription.php" method="POST">
        <label for="pseudo">Pseudo :</label><br>
        <input type="text" id="pseudo" name="pseudo" maxlength="25" required>

        <br><br>

        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" maxlength="100" required>

        <br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p><a href="connexion.php">Déjà un compte ? Se connecter</a></p>
</body>

</html>
