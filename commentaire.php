<?php
session_start();
require_once 'database.php';
require_once 'classes/user.php';
require_once 'classes/comment.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: inscription_connexion.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = trim($_POST['commentaire']);
    $id_user = $_SESSION['user']['id'];

    if (!empty($commentaire)) {
        try {
            $query = 'INSERT INTO comment (comment, id_user, date) VALUES (:comment, :id_user, NOW())';
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':comment', $commentaire, PDO::PARAM_STR);
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: livre-or.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Erreur lors de l\'ajout : ' . htmlspecialchars($e->getMessage());
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

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
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