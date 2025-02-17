<?php
require 'database.php';
require_once 'classes/user.php';
require_once 'classes/comment.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Livre d'Or</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur notre Livre d'Or</h1>
    </header>

    <nav>
        <ul>
            <li><a href="inscription_connexion.php">S'inscrire</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="profil.php">Modifier mon profil</a></li>
            <li><a href="livre-or.php">Voir le Livre d'Or</a></li>
        </ul>
    </nav>

    <main class="container accueil">
        <p>Sur ce site, vous pouvez vous inscrire, vous connecter, modifier vos informations personnelles, et laisser un commentaire dans notre Livre d'Or.</p>
        <p>N'hésitez pas à explorer les différentes sections via le menu ci-dessus.</p>
    </main>

    <footer>
        <p>&copy; 2025 Livre D'Or. Tous droits réservés.</p>
    </footer>
</body>
</html>
