<?php
require_once 'database.php';
require_once 'classes/User.php';
require_once 'classes/Comment.php';

session_start();

// Initialisation des classes
$user = new User($pdo);
$comment = new Comment($pdo);

// Nombre de commentaires par page
$commentsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Recherche par mots-clés (si saisie dans la barre de recherche)
$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';

// Récupération des commentaires avec pagination
$comments = $comment->getCommentaires($page, $commentsPerPage);
$totalComments = $comment->countCommentaires($search);

// Calculer le nombre total de pages
$totalPages = ceil($totalComments / $commentsPerPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-livre-or">
    <h1>Livre d'Or</h1>

    <!-- Formulaire de recherche -->
    <form action="livre-or.php" method="GET">
        <input type="text" name="search" placeholder="Mots clés" value="<?= $search ?>">
        <button type="submit">Rechercher</button>
    </form>

    <!-- Affichage des commentaires -->
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comment['login']); ?></strong> (Posté le <?= date('d/m/Y', strtotime($comment['date'])); ?>)</p>
                <p><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun commentaire trouvé.</p>
    <?php endif; ?>
    

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&search=<?= $search ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= $search ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= $search ?>">Suivant</a>
        <?php endif; ?>
    </div>
    <!-- Ajouter un commentaire (si connecté) -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div>
            <a href="commentaire.php" class="btn btn-primary">Ajouter un commentaire</a>
        </div>
    <?php endif; ?>

    <p>Retour           <a href="index.php">Accueil</a></p>


</body>
</html>