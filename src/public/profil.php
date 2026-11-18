<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre profil - Proximusic</title>
</head>

<body>
    <main>
        <h1>Votre profil</h1>

        <p>
            La consultation des informations du compte et leur sauvegarde
            seront ajoutées après le cours sur les sessions.
        </p>

        <form>
            <p>
                <label for="pseudo">Pseudo</label><br>
                <input
                    type="text"
                    id="pseudo"
                    name="pseudo"
                    maxlength="25"
                    autocomplete="username"
                    required
                >
            </p>

            <p>
                <label for="email">Adresse e-mail</label><br>
                <input
                    type="email"
                    id="email"
                    name="email"
                    maxlength="100"
                    autocomplete="email"
                    required
                >
            </p>

            <p>
                <label for="password">Nouveau mot de passe</label><br>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    aria-describedby="password-help"
                >
            </p>

            <p id="password-help">
                Laisse ce champ vide pour conserver ton mot de passe.
            </p>

            <p>
                <label for="bio">Votre bio</label><br>
                <textarea
                    id="bio"
                    name="bio"
                    rows="10"
                    cols="35"
                    maxlength="500"
                    placeholder="Votre bio..."
                ></textarea>
            </p>

            <button type="button" disabled>
                Sauvegarder
            </button>
        </form>

        <p><a href="index.php">Retour à l’accueil</a></p>
    </main>
</body>

</html>
