<?php
session_start();
require_once 'Config/Database.php';
require_once 'Classes/User.php';
require_once 'Classes/Comment.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}

// Initialisation de la classe Comment
$commentClass = new Comment($pdo);

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = trim($_POST['commentaire']);
    $id_user = $_SESSION['user']['id'];

    if (!empty($commentaire)) {
        if ($commentClass->ajouterCommentaire($id_user, $commentaire)) {
            // Redirection pour éviter la resoumission du formulaire
            header('Location: livre-or.php?success=1');
            exit;
        } else {
            $error = 'Erreur lors de l\'ajout du commentaire.';
        }
    } else {
        $error = 'Le champ commentaire est vide.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-commentaire">
    <h1>Ajouter un Commentaire</h1>

    <!-- Affichage des erreurs éventuelles -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="commentaire.php" method="post">
        <label for="commentaire">Votre commentaire :</label>
        <textarea id="commentaire" name="commentaire" rows="5" cols="50" placeholder="Votre commentaire ici..."><?php echo isset($commentaire) ? htmlspecialchars($commentaire) : ''; ?></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>

    <p><a href="livre-or.php">Retour au Livre d'Or</a></p>
</body>
</html>