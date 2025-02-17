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
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenue sur notre site</h1>
            <p>Inscrivez-vous, connectez-vous et laissez vos commentaires dans notre Livre d'Or.</p>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="inscription_connexion.php">S'inscrire</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="profil.php">Modifier mon profil</a></li>
                <li><a href="livre-or.php">Voir le Livre d'Or</a></li>
            </ul>
        </div>
    </nav>

    <footer>
        <div class="container">
            <p>&copy; 2025 Livre D'Or. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>