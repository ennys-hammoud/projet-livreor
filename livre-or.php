<?php
// livre-or.php
require_once 'Config/Database.php';
require_once 'Classes/User.php';
require_once 'Classes/Comment.php';

session_start();

$user = new User($pdo);
$comment = new Comment($pdo);

$commentsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';

$comments = $comment->getCommentaires($page, $commentsPerPage, $search);
$totalComments = $comment->countCommentaires($search);
$totalPages = ceil($totalComments / $commentsPerPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles.css?v=1.0">
</head>
<body class="page-livre-or">
    <h1>Livre d'Or</h1>
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"> <?= htmlspecialchars($_GET['message']); ?> </p>
    <?php endif; ?>

    <form action="livre-or.php" method="GET" class="form-recherche">
        <input type="text" name="search" placeholder="Mots clés" value="<?= $search ?>">
        <button type="submit">Rechercher</button>
    </form>

    <?php foreach ($comments as $c): ?>
        <div class="comment">
            <p><strong><?= htmlspecialchars($c['login']); ?></strong> (Posté le <?= date('d/m/Y', strtotime($c['date'])); ?>)</p>
            <p><?= nl2br(htmlspecialchars($c['comment'])); ?></p>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['login'] === 'ennys'): ?>
                <form action="supprimer_commentaire.php" method="POST" class="form-suppression">
                <input type="hidden" name="comment_id" value="<?= $c['id']; ?>">
                <button type="submit" class="btn-supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">Supprimer</button>
</form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

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

    <?php if (isset($_SESSION['user'])): ?>
        <a href="commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['login'] === 'ennys'): ?>
    <p><a href="deconnexion.php">Se déconnecter</a></p>
<?php else: ?>
    <p><a href="index.php">Retour à l'accueil</a></p>
<?php endif; ?>

</body>
</html>