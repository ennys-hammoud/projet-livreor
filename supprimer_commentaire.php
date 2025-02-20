<?php
// supprimer_commentaire.php
session_start();
require_once 'Config/Database.php';
require_once 'Classes/Comment.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'ennys') {
    header('Location: livre-or.php?message=Accès interdit');
    exit;
}

$commentClass = new Comment($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
    $commentId = intval($_POST['comment_id']);
    $success = $commentClass->supprimerCommentaire($commentId);
    $message = $success ? 'Commentaire supprimé' : 'Erreur lors de la suppression';

    header('Location: livre-or.php?message=' . urlencode($message));
    exit;
} else {
    header('Location: livre-or.php?message=Requête invalide');
    exit;
}